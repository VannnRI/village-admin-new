<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use App\Models\Citizen;
use Illuminate\Support\Facades\Auth;

class CitizensImport implements ToCollection, WithHeadingRow, WithValidation
{
    protected $villageId;

    public function __construct($villageId)
    {
        $this->villageId = $villageId;
    }

    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {
            // Skip empty rows or missing required fields
            if (empty($row['nik']) || empty($row['nama']) || empty($row['no_kk']) || empty($row['tempat_lahir']) || 
                empty($row['tanggal_lahir']) || empty($row['alamat']) || empty($row['jenis_kelamin']) || 
                empty($row['agama']) || empty($row['status_perkawinan']) || empty($row['pendidikan']) || 
                empty($row['pekerjaan']) || empty($row['kewarganegaraan'])) {
                continue;
            }

            // Check if NIK already exists
            $existingCitizen = Citizen::where('nik', $row['nik'])->first();
            if ($existingCitizen) {
                continue; // Skip if NIK already exists
            }

            Citizen::create([
                'village_id' => $this->villageId,
                'nik' => $row['nik'],
                'kk_number' => $row['no_kk'] ?? null,
                'name' => $row['nama'],
                'birth_place' => $row['tempat_lahir'] ?? null,
                'birth_date' => $this->parseDate($row['tanggal_lahir'] ?? null),
                'address' => $row['alamat'] ?? null,
                'phone' => $row['no_telepon'] ?? null,
                'email' => $row['email'] ?? null,
                'gender' => $this->parseGender($row['jenis_kelamin'] ?? null),
                'religion' => $row['agama'] ?? null,
                'marital_status' => $row['status_perkawinan'] ?? null,
                'education' => $row['pendidikan'] ?? null,
                'job' => $row['pekerjaan'] ?? null,
                'nationality' => $row['kewarganegaraan'] ?? null,
            ]);
        }
    }

    public function rules(): array
    {
        return [
            'nik' => 'required|string|size:16',
            'nama' => 'required|string|max:255',
            'no_kk' => 'required|string|size:16',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|string',
            'alamat' => 'required|string|max:255',
            'no_telepon' => 'nullable|string|max:32',
            'email' => 'nullable|email|max:255',
            'jenis_kelamin' => 'required|string|in:L,P,Laki-laki,Perempuan',
            'agama' => 'required|string|max:32',
            'status_perkawinan' => 'required|string|max:32',
            'pendidikan' => 'required|string|max:32',
            'pekerjaan' => 'required|string|max:64',
            'kewarganegaraan' => 'required|string|max:64',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'nik.required' => 'NIK wajib diisi',
            'nik.size' => 'NIK harus 16 digit',
            'nama.required' => 'Nama wajib diisi',
            'no_kk.required' => 'No KK wajib diisi',
            'no_kk.size' => 'No KK harus 16 digit',
            'tempat_lahir.required' => 'Tempat lahir wajib diisi',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi',
            'alamat.required' => 'Alamat wajib diisi',
            'jenis_kelamin.required' => 'Jenis kelamin wajib diisi',
            'jenis_kelamin.in' => 'Jenis kelamin harus L/P atau Laki-laki/Perempuan',
            'agama.required' => 'Agama wajib diisi',
            'status_perkawinan.required' => 'Status perkawinan wajib diisi',
            'pendidikan.required' => 'Pendidikan wajib diisi',
            'pekerjaan.required' => 'Pekerjaan wajib diisi',
            'kewarganegaraan.required' => 'Kewarganegaraan wajib diisi',
        ];
    }

    private function parseDate($date)
    {
        if (empty($date)) {
            return null;
        }

        // Try different date formats
        $formats = ['d/m/Y', 'Y-m-d', 'd-m-Y', 'Y/m/d'];
        
        foreach ($formats as $format) {
            $parsed = \DateTime::createFromFormat($format, $date);
            if ($parsed) {
                return $parsed->format('Y-m-d');
            }
        }

        return null;
    }

    private function parseGender($gender)
    {
        if (empty($gender)) {
            return null;
        }

        $gender = strtolower(trim($gender));
        
        if (in_array($gender, ['l', 'laki-laki', 'laki laki'])) {
            return 'L';
        } elseif (in_array($gender, ['p', 'perempuan'])) {
            return 'P';
        }

        return null;
    }
}
