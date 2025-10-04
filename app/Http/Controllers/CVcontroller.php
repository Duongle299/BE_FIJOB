<?php

namespace App\Http\Controllers;

use App\Models\Hosoungvien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpWord\IOFactory;
use Smalot\PdfParser\Parser;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
class CVcontroller extends Controller
{
    public function UploadCV(Request $request)
    {
        $request->validate([
            'cv_file' => 'required|file|mimes:pdf,docx|max:10240', // 10MB max
        ], [
            'cv_file.required' => 'Vui lòng chọn file CV.',
            'cv_file.file' => 'Dữ liệu không phải là file.',
            'cv_file.mimes' => 'Chỉ hỗ trợ file PDF hoặc DOCX.',
            'cv_file.max' => 'Kích thước file quá lớn (tối đa 10MB).',
        ]);
        $file = $request->file('cv_file');
        $extension = $file->getClientOriginalExtension();
        $filePath = $file->getRealPath();
        $text = '';
        try {
            // 2. LƯU FILE VÀ LẤY ĐƯỜNG DẪN (cv_path)
            $fileName = time() . '_' . Str::random(10) . '.' . $extension;
            // Lưu file vào thư mục 'public/cvs'
            $storagePath = $file->storeAs('public/cvs', $fileName);
            $publicPath = str_replace('public/', 'storage/', $storagePath); // Đường dẫn công khai

            // 3. Đọc nội dung file
            if ($extension === 'pdf') {
                $text = $this->readPDF($filePath); // Sử dụng $this->
            } elseif ($extension === 'docx') {
                $text = $this->readDOCX($filePath); // Sử dụng $this->
            }

            // 4. Parse Content
            $parsedData = $this->parseCVText($text); // Sử dụng $this->

            // 5. LƯU DỮ LIỆU VÀO DATABASE
            $parsedData['cv_path'] = $publicPath; // Thêm đường dẫn vào dữ liệu parse

            // Thực hiện lưu vào database ở đây:
            // HoSoUngVien::create($parsedData);

            // 6. Trả về kết quả
            return response()->json([
                'message' => 'CV đã được tải lên và xử lý thành công!',
                'data' => $parsedData,
                'cv_url' => asset($publicPath),
            ]);

        } catch (\Exception $e) {
            // Log lỗi và xóa file nếu đã lưu
            if ($storagePath) {
                Storage::delete($storagePath);
            }
            Log::error("CV Processing Error: " . $e->getMessage(), ['file' => $file->getClientOriginalName()]);
            return response()->json(['message' => 'Đã xảy ra lỗi trong quá trình xử lý CV. Vui lòng thử lại.'], 500);
        }
    }
    // đọc nội dung từ file
    private function readPDF(string $filePath): string
    {
        $parser = new Parser();
        $pdf = $parser->parseFile($filePath);
        return $pdf->getText();
    }
    /**
     * Đọc nội dung từ file DOCX.
     */
    private function readDOCX(string $filePath): string
    {
        // Sử dụng PhpOffice\PhpWord
        $phpWord = IOFactory::load($filePath);
        $text = '';
        foreach ($phpWord->getSections() as $section) {
            foreach ($section->getElements() as $element) {
                // Handle Text elements
                if ($element instanceof \PhpOffice\PhpWord\Element\Text) {
                    $text .= $element->getText() . "\n";
                }
                // Handle TextRun elements
                elseif ($element instanceof \PhpOffice\PhpWord\Element\TextRun) {
                    foreach ($element->getElements() as $subElement) {
                        if ($subElement instanceof \PhpOffice\PhpWord\Element\Text) {
                            $text .= $subElement->getText();
                        }
                    }
                    $text .= "\n";
                }
                // Optionally handle other element types if needed
            }
        }
        return $text;
    }
    private function parseCVText(string $text): array
    {
        $data = [
            'name' => null,
            'email' => null,
            'phone' => null,
            'birthYear' => null,
            'gender' => null,
            'maritalStatus' => null,
            'address' => null,
            'idCard' => null,
            'education' => null,
            'position' => null,
            'industry' => null,
            'experience' => null,
            'salary' => null,
            'cv_path' => null,
        ];
        $lowerText = mb_strtolower($text, 'UTF-8');

        // ===== EMAIL =====
        if (preg_match('/\b[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}\b/i', $text, $match)) {
            $data['email'] = $match[0];
        }

        // ===== SỐ ĐIỆN THOẠI =====
        if (preg_match('/(0\d{9,10})/', $text, $match)) {
            $data['phone'] = $match[0];
        }

        // ===== NĂM SINH =====
        if (preg_match('/\b(19[5-9]\d|20[0-2]\d|20[0-9]{2})\b/', $text, $match)) {
            $data['birthYear'] = $match[0];
        }

        // ===== GIỚI TÍNH =====
        if (preg_match('/nam/', $lowerText)) {
            $data['gender'] = 'Nam';
        } elseif (preg_match('/nữ/', $lowerText)) {
            $data['gender'] = 'Nữ';
        }

        // ===== TÌNH TRẠNG HÔN NHÂN =====
        if (preg_match('/chưa kết hôn|độc thân/', $lowerText)) {
            $data['maritalStatus'] = 'Chưa kết hôn';
        } elseif (preg_match('/đã kết hôn|có gia đình/', $lowerText)) {
            $data['maritalStatus'] = 'Đã kết hôn';
        }

        // ===== ĐỊA CHỈ =====
        if (preg_match('/(?:Địa chỉ|Address)[:\-]?\s*(.+)/i', $text, $match)) {
            $data['address'] = trim(explode("\n", $match[1])[0]);
        }

        // ===== CĂN CƯỚC CÔNG DÂN / CMND =====
        if (preg_match('/\b\d{9}\b|\b\d{12}\b/', $text, $match)) {
            $data['idCard'] = $match[0];
        }

        // ===== HỌC VẤN =====
        if (preg_match('/thạc sĩ|tiến sĩ|trên đại học/', $lowerText)) {
            $data['education'] = 'Trên đại học';
        } elseif (preg_match('/đại học/', $lowerText)) {
            $data['education'] = 'Đại học';
        } elseif (preg_match('/cao đẳng/', $lowerText)) {
            $data['education'] = 'Cao đẳng';
        } elseif (preg_match('/trung học phổ thông|thpt/', $lowerText)) {
            $data['education'] = 'Trung học phổ thông';
        } elseif (preg_match('/trung học cơ sở|thcs/', $lowerText)) {
            $data['education'] = 'Trung học cơ sở';
        } elseif (preg_match('/tiểu học/', $lowerText)) {
            $data['education'] = 'Tiểu học';
        }


        // ===== VỊ TRÍ ỨNG TUYỂN =====
        if (preg_match('/(?:Vị trí ứng tuyển|Position)[:\-]?\s*(.+)/i', $text, $match)) {
            $data['position'] = trim(explode("\n", $match[1])[0]);
        }

        // ===== NGÀNH NGHỀ =====
        if (preg_match('/(?:Ngành nghề|Industry)[:\-]?\s*(.+)/i', $text, $match)) {
            $data['industry'] = trim(explode("\n", $match[1])[0]);
        }

        // ===== KINH NGHIỆM =====
        if (preg_match('/(?:Kinh nghiệm|Experience)[:\-]?\s*([\s\S]+?)(?=\n(?:Vị trí ứng tuyển|Ngành nghề|Trình độ|Education|Expected salary|$))/i', $text, $match)) {
            $experienceText = $match[1];
            $data['experience'] = collect(explode("\n", $experienceText))
                ->map(fn($line) => trim($line))
                ->filter(fn($line) => !empty($line))
                ->implode("\n");
        } elseif (preg_match('/(\d+)\s+năm\s+kinh nghiệm/i', $text, $match)) {
            $data['experience'] = $match[0];
        }


        // ===== LƯƠNG MONG MUỐN =====
        if (preg_match('/(?:Mức lương mong muốn|Expected salary)[:\-]?\s*(.+)/i', $text, $match)) {
            $data['salary'] = trim(explode("\n", $match[1])[0]);
        }

        // ===== HỌ TÊN =====
        if (preg_match('/(?:Họ và tên|Full name)[:\-]?\s*(.+)/i', $text, $match)) {
            $data['name'] = trim(explode("\n", $match[1])[0]);
        } else {
            $firstLine = explode("\n", $text)[0] ?? '';
            $words = explode(" ", trim($firstLine));
            if (count($words) <= 5) {
                $data['name'] = trim($firstLine);
            }
        }
        return $data;
    }
    public function ungtuyen(Request $request)
    {
        $data = $request->all();
        $salaryValue = (int) filter_var($data['salary'] ?? '0', FILTER_SANITIZE_NUMBER_INT) ?? 0;
        $hoSo = Hosoungvien::create([
                'id_ung_vien' => Auth::guard('sanctum')->user()->id,
                'id_nhatuyendung' => $data['id_nhatuyendung'] ?? null, // Cẩn thận với NULL
                'ho_ten' => $data['name'] ?? null,
                'email' => $data['email'] ?? null,
                'so_dien_thoai' => $data['phone'] ?? null,
                'nam_sinh' => $data['birthYear'] ?? null,
                'gioi_tinh' => $data['gender'] ?? null,
                'hon_nhan' => $data['maritalStatus'] ?? null,
                'dia_chi' => $data['address'] ?? null,
                'so_cmnd_cccd' => $data['idCard'] ?? null,
                'trinh_do_hoc_van' => $data['education'] ?? null,
                'muc_luong_mong_muon' => $salaryValue,
                'vi_tri_ung_tuyen' => $data['position'] ?? null,
                'nganh_nghe' => $data['industry'] ?? null,
                'kinh_nghiem' => $data['experience'] ?? null,
                // Mặc định cho các trường khác
                'cv_path' => null,
                'cap_bac_mong_muon' => $data['position'] ?? null,
                'trang_thai' => 0,
            ]);
            return response()->json([
                'status' => 1,
                'message' => 'Đã nộp hồ sơ ứng tuyển thành công!'
            ]);
    }
}
