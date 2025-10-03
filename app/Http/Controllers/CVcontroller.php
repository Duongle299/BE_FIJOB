<?php

namespace App\Http\Controllers;

use App\Models\Hosoungvien;
use Illuminate\Http\Request;
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
        DB::beginTransaction();
        try {
            // 1. Validation (Sử dụng tên trường từ Frontend)
            $validated = $request->validate([
                'id_nhatuyendung' => 'required|integer|exists:nhatuyendungs,id',
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:hosoungviens,email',
                'phone' => 'required|string|max:20',
                'birthYear' => 'nullable|integer',
                'gender' => 'nullable|string|max:10',
                'maritalStatus' => 'nullable|string|max:50',
                'address' => 'nullable|string|max:255',
                'idCard' => 'nullable|string|max:20',
                'education' => 'nullable|string|max:100',
                'salary' => 'nullable|string|max:100', // Frontend gửi string (VND/tháng)
                'position' => 'required|string|max:150',
                'industry' => 'nullable|string|max:100',
                'experience' => 'nullable|string',
                // 'cv_file' => 'required|file|mimes:pdf,docx|max:10240',
            ]);

            // 2. Xử lý Upload File CV
            // $cvPath = $request->file('cv_file')->store('public/cv_uploads');
            $cvPath =null;
            // LÀM SẠCH LƯƠNG: Chuyển '20,000,000 VND / tháng' sang số nguyên
            $salaryValue = (int) filter_var($validated['salary'], FILTER_SANITIZE_NUMBER_INT) ?? 0;


            // 3. Ánh xạ và Lưu dữ liệu (Map Request fields to Vietnamese DB columns)
            $hoSo = Hosoungvien::create([
                // Các trường từ Model $fillable
                'id_nhatuyendung' => $validated['id_nhatuyendung'],
                'ho_ten' => $validated['name'],
                'email' => $validated['email'],
                'so_dien_thoai' => $validated['phone'], // Giả sử tên cột là so_dien_thoai
                'nam_sinh' => $validated['birthYear'] ?? null,
                'gioi_tinh' => $validated['gender'] ?? null,
                'dia_chi' => $validated['address'] ?? null,
                'so_cmnd_cccd' => $validated['idCard'] ?? null,
                'hon_nhan' => $validated['maritalStatus'] ?? null,
                'trinh_do_hoc_van' => $validated['education'] ?? null,
                'muc_luong_mong_muon' => $salaryValue,
                'vi_tri_ung_tuyen' => $validated['position'],
                'nganh_nghe' => $validated['industry'] ?? null,
                'kinh_nghiem' => $validated['experience'] ?? null,
                'cv_path' => $cvPath,
                // Các trường khác (Giả định giá trị)
                'cap_bac_mong_muon' => $validated['position'], // Giả sử vị trí = cấp bậc mong muốn
                'trang_thai' => 0, // Mặc định: Chờ duyệt
                'id_ung_vien' => null, // Không có tài khoản ứng viên (nếu có thì lấy ID user)
            ]);

            DB::commit();

            // 4. Trả về thành công
            return response()->json([
                'message' => 'Hồ sơ ứng viên đã được nộp thành công!',
                'ho_so_id' => $hoSo->id,
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            // Xóa file nếu đã lưu trước khi lỗi xảy ra
            if (isset($cvPath)) {
                Storage::delete($cvPath);
            }
            Log::error('Lỗi khi nộp hồ sơ ứng viên: ' . $e->getMessage());

            return response()->json([
                'message' => 'Lỗi: Không thể nộp hồ sơ. Vui lòng thử lại. Vui lòng kiểm tra log server.',
                'error_detail' => $e->getMessage()
            ], 500);
        }

    }
}
