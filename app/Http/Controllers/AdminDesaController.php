<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Village;
use App\Models\Citizen;
use App\Models\LetterRequest;
use App\Models\LetterType;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Collection;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Archive;
use App\Imports\CitizensImport;
use App\Exports\CitizensTemplateExport;

class AdminDesaController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $village = $user->villages()->first();
        
        if (!$village) {
            return redirect()->route('login')->with('error', 'Anda tidak terikat dengan desa manapun.');
        }

        $totalCitizens = Citizen::where('village_id', $village->id)->count();
        $pendingLetters = LetterRequest::where('village_id', $village->id)
                                      ->where('status', 'pending')
                                      ->count();
        $approvedLetters = LetterRequest::where('village_id', $village->id)
                                       ->where('status', 'approved')
                                       ->count();

        return view('admin-desa.dashboard', compact('village', 'totalCitizens', 'pendingLetters', 'approvedLetters'));
    }

    public function citizens()
    {
        $user = Auth::user();
        $village = $user->villages()->first();
        
        if (!$village) {
            return redirect()->route('login')->with('error', 'Anda tidak terikat dengan desa manapun.');
        }

        $citizens = Citizen::where('village_id', $village->id)->get();
        return view('admin-desa.citizens.index', compact('citizens', 'village'));
    }

    public function createCitizen()
    {
        $user = Auth::user();
        $village = $user->villages()->first();
        
        if (!$village) {
            return redirect()->route('login')->with('error', 'Anda tidak terikat dengan desa manapun.');
        }

        return view('admin-desa.citizens.create', compact('village'));
    }

    public function storeCitizen(Request $request)
    {
        $user = Auth::user();
        $village = $user->villages()->first();
        
        $request->validate([
            'nik' => 'required|string|size:16|unique:citizens,nik',
            'kk_number' => 'required|string|size:16',
            'name' => 'required|string|max:255',
            'birth_place' => 'required|string|max:100',
            'birth_date' => 'required|date',
            'address' => 'required|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
            'gender' => 'required|in:L,P',
            'religion' => 'required|string',
            'marital_status' => 'required|string',
            'education' => 'required|string',
            'job' => 'required|string',
            'nationality' => 'required|string|max:64'
        ]);

        Citizen::create([
            'village_id' => $village->id,
            'nik' => $request->nik,
            'kk_number' => $request->kk_number,
            'name' => $request->name,
            'birth_place' => $request->birth_place,
            'birth_date' => $request->birth_date,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
            'gender' => $request->gender,
            'religion' => $request->religion,
            'marital_status' => $request->marital_status,
            'education' => $request->education,
            'job' => $request->job,
            'nationality' => $request->nationality
        ]);

        return redirect()->route('admin-desa.citizens.index')->with('success', 'Data penduduk berhasil ditambahkan');
    }

    public function editCitizen($id)
    {
        $user = Auth::user();
        $village = $user->villages()->first();
        
        if (!$village) {
            return redirect()->route('login')->with('error', 'Anda tidak terikat dengan desa manapun.');
        }

        $citizen = Citizen::where('village_id', $village->id)->findOrFail($id);
        return view('admin-desa.citizens.edit', compact('citizen', 'village'));
    }

    public function updateCitizen(Request $request, $id)
    {
        $user = Auth::user();
        $village = $user->villages()->first();
        
        if (!$village) {
            return redirect()->route('login')->with('error', 'Anda tidak terikat dengan desa manapun.');
        }

        $citizen = Citizen::where('village_id', $village->id)->findOrFail($id);
        
        $request->validate([
            'nik' => 'required|string|size:16|unique:citizens,nik,' . $id,
            'kk_number' => 'required|string|size:16',
            'name' => 'required|string|max:255',
            'birth_place' => 'required|string|max:100',
            'birth_date' => 'required|date',
            'address' => 'required|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
            'gender' => 'required|in:L,P',
            'religion' => 'required|string',
            'marital_status' => 'required|string',
            'education' => 'required|string',
            'job' => 'required|string',
            'nationality' => 'required|string|max:64'
        ]);

        $citizen->update($request->all());

        return redirect()->route('admin-desa.citizens.index')->with('success', 'Data penduduk berhasil diperbarui');
    }

    public function destroyCitizen($id)
    {
        $user = Auth::user();
        $village = $user->villages()->first();
        
        if (!$village) {
            return redirect()->route('login')->with('error', 'Anda tidak terikat dengan desa manapun.');
        }

        $citizen = Citizen::where('village_id', $village->id)->findOrFail($id);
        
        // Check if citizen has letter requests
        if ($citizen->letterRequests()->count() > 0) {
            return redirect()->route('admin-desa.citizens.index')->with('error', 'Tidak dapat menghapus penduduk yang memiliki pengajuan surat.');
        }
        
        $citizen->delete();

        return redirect()->route('admin-desa.citizens.index')->with('success', 'Data penduduk berhasil dihapus');
    }

    public function downloadTemplate()
    {
        return Excel::download(new CitizensTemplateExport, 'template_data_penduduk.xlsx');
    }

    public function importCitizens(Request $request)
    {
        $user = Auth::user();
        $village = $user->villages()->first();
        
        if (!$village) {
            return redirect()->route('login')->with('error', 'Anda tidak terikat dengan desa manapun.');
        }

        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls',
        ]);

        try {
            Excel::import(new CitizensImport($village->id), $request->file('file'));
            
            return redirect()->route('admin-desa.citizens.index')->with('success', 'Data penduduk berhasil diimport');
        } catch (\Exception $e) {
            return redirect()->route('admin-desa.citizens.index')->with('error', 'Gagal import data: ' . $e->getMessage());
        }
    }

    public function letterRequests()
    {
        $user = Auth::user();
        $village = $user->villages()->first();
        
        if (!$village) {
            return redirect()->route('login')->with('error', 'Anda tidak terikat dengan desa manapun.');
        }

        $letterRequests = LetterRequest::where('village_id', $village->id)
                                      ->with(['citizen', 'letterType'])
                                      ->orderBy('created_at', 'desc')
                                      ->get();

        return view('admin-desa.letter-requests.index', compact('letterRequests', 'village'));
    }

    public function villageProfile()
    {
        $user = Auth::user();
        $village = $user->villages()->first();
        
        if (!$village) {
            return redirect()->route('login')->with('error', 'Anda tidak terikat dengan desa manapun.');
        }

        return view('admin-desa.village.profile', compact('village'));
    }

    public function updateVillageProfile(Request $request)
    {
        $user = Auth::user();
        $village = $user->villages()->first();
        
        if (!$village) {
            return redirect()->route('login')->with('error', 'Anda tidak terikat dengan desa manapun.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
            'website' => 'nullable|url',
            'vision' => 'nullable|string',
            'mission' => 'nullable|string',
            'postal_code' => 'nullable|string',
            'village_code' => 'nullable|string',
            'number_format' => 'nullable|string',
            'district' => 'nullable|string|max:100',
            'regency' => 'nullable|string|max:100',
        ]);
        $village->update($request->only([
            'name', 'description', 'address', 'phone', 'email', 'website', 'vision', 'mission',
            'district', 'regency', 'postal_code', 'village_code', 'number_format'
        ]));

        return redirect()->route('admin-desa.village.profile')->with('success', 'Profil desa berhasil diperbarui');
    }

    // Arsip Administrasi
    public function archives()
    {
        $user = Auth::user();
        $village = $user->villages()->first();
        
        if (!$village) {
            return redirect()->route('login')->with('error', 'Anda tidak terikat dengan desa manapun.');
        }

        return view('admin-desa.archives.index', compact('village'));
    }

    public function generalArchives()
    {
        $user = Auth::user();
        $village = $user->villages()->first();
        
        if (!$village) {
            return redirect()->route('login')->with('error', 'Anda tidak terikat dengan desa manapun.');
        }

        // Ambil data arsip umum dari database
        $generalDocuments = Archive::where('village_id', $village->id)
            ->where('type', 'general')
            ->orderByDesc('date')
            ->get();

        return view('admin-desa.archives.general', compact('village', 'generalDocuments'));
    }

    public function populationArchives()
    {
        $user = Auth::user();
        $village = $user->villages()->first();
        
        if (!$village) {
            return redirect()->route('login')->with('error', 'Anda tidak terikat dengan desa manapun.');
        }

        $citizens = Citizen::where('village_id', $village->id)
                          ->orderBy('name', 'asc')
                          ->get();

        return view('admin-desa.archives.population', compact('village', 'citizens'));
    }

    public function letterArchives()
    {
        $user = Auth::user();
        $village = $user->villages()->first();
        
        if (!$village) {
            return redirect()->route('login')->with('error', 'Anda tidak terikat dengan desa manapun.');
        }

        $letterRequests = LetterRequest::where('village_id', $village->id)
                                      ->with(['citizen', 'letterType'])
                                      ->orderBy('created_at', 'desc')
                                      ->get();

        // Group by status
        $pendingLetters = $letterRequests->where('status', 'pending');
        $approvedLetters = $letterRequests->where('status', 'approved');
        $rejectedLetters = $letterRequests->where('status', 'rejected');
        $completedLetters = $letterRequests->where('status', 'completed');

        return view('admin-desa.archives.letter-archives', compact(
            'village', 
            'letterRequests', 
            'pendingLetters', 
            'approvedLetters', 
            'rejectedLetters', 
            'completedLetters'
        ));
    }

    public function downloadArchive($type, $format = 'excel')
    {
        $user = Auth::user();
        $village = $user->villages()->first();
        if (!$village) {
            return redirect()->route('login')->with('error', 'Anda tidak terikat dengan desa manapun.');
        }

        switch ($type) {
            case 'general':
                // Cari file di database berdasarkan nama file dan village
                $archive = Archive::where('village_id', $village->id)
                    ->where('type', 'general')
                    ->where('file', $format)
                    ->first();
                if (!$archive) {
                    return back()->with('error', 'File tidak ditemukan atau tidak diizinkan.');
                }
                $path = storage_path('app/public/archives/general/' . $archive->file);
                if (!file_exists($path)) {
                    return back()->with('error', 'File tidak ditemukan di server.');
                }
                return response()->download($path, $archive->file, [
                    'Content-Type' => mime_content_type($path),
                    'Content-Disposition' => 'attachment; filename="' . $archive->file . '"',
                ]);
            case 'population':
                return $this->exportPopulationData($village, $format);
            case 'letters':
                return $this->exportLetterData($village, $format);
            default:
                return back()->with('error', 'Tipe arsip tidak valid');
        }
    }

    private function exportPopulationData($village, $format = 'excel')
    {
        $citizens = \App\Models\Citizen::where('village_id', $village->id)->get();
        $filename = 'data_penduduk_' . now()->format('Ymd_His');
        $export = new class($citizens) implements \Maatwebsite\Excel\Concerns\FromCollection, \Maatwebsite\Excel\Concerns\WithHeadings {
            private $data;
            public function __construct($data) { $this->data = $data; }
            public function collection() { return new Collection($this->data); }
            public function headings(): array {
                return [
                    'ID', 'NIK', 'No KK', 'Nama', 'Tanggal Lahir', 'Alamat', 'Telepon', 'Email', 'Jenis Kelamin', 'Agama', 'Status Perkawinan', 'Pendidikan', 'Pekerjaan', 'Dibuat', 'Diperbarui'
                ];
            }
        };
        if ($format === 'csv') {
            return Excel::download($export, $filename . '.csv', \Maatwebsite\Excel\Excel::CSV);
        } elseif ($format === 'pdf') {
            $pdf = Pdf::loadView('admin-desa.archives.exports.population-pdf', ['citizens' => $citizens]);
            return $pdf->download($filename . '.pdf');
        } else {
            return Excel::download($export, $filename . '.xlsx');
        }
    }

    private function exportLetterData($village, $format = 'excel')
    {
        $letterRequests = \App\Models\LetterRequest::where('village_id', $village->id)->with(['citizen', 'letterType'])->get();
        $filename = 'data_surat_' . now()->format('Ymd_His');
        $export = new class($letterRequests) implements \Maatwebsite\Excel\Concerns\FromCollection, \Maatwebsite\Excel\Concerns\WithHeadings {
            private $data;
            public function __construct($data) { $this->data = $data; }
            public function collection() {
                return new Collection($this->data->map(function($item) {
                    return [
                        $item->id,
                        $item->citizen ? $item->citizen->name : '',
                        $item->letterType ? $item->letterType->name : '',
                        $item->status,
                        $item->created_at,
                        $item->updated_at
                    ];
                }));
            }
            public function headings(): array {
                return [
                    'ID', 'Nama Pemohon', 'Jenis Surat', 'Status', 'Dibuat', 'Diperbarui'
                ];
            }
        };
        if ($format === 'csv') {
            return Excel::download($export, $filename . '.csv', \Maatwebsite\Excel\Excel::CSV);
        } elseif ($format === 'pdf') {
            $pdf = Pdf::loadView('admin-desa.archives.exports.letters-pdf', ['letterRequests' => $letterRequests]);
            return $pdf->download($filename . '.pdf');
        } else {
            return Excel::download($export, $filename . '.xlsx');
        }
    }

    public function storeGeneralArchive(Request $request)
    {
        $user = Auth::user();
        $village = $user->villages()->first();
        
        if (!$village) {
            return redirect()->route('login')->with('error', 'Anda tidak terikat dengan desa manapun.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'description' => 'nullable|string',
            'file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx|max:10240', // 10MB max
        ]);

        $file = $request->file('file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('archives/general', $fileName, 'public');
        
        Archive::create([
            'village_id' => $village->id,
            'title' => $request->title,
            'type' => 'general',
            'category' => $request->category,
            'description' => $request->description,
            'file' => $fileName,
            'size' => $file->getSize(),
            'date' => now(),
            'uploaded_by' => $user->name
        ]);

        return redirect()->route('admin-desa.archives.archives.general')->with('success', 'Dokumen berhasil diupload');
    }

    public function editGeneralArchive($id)
    {
        $user = Auth::user();
        $village = $user->villages()->first();
        if (!$village) {
            return redirect()->route('login')->with('error', 'Anda tidak terikat dengan desa manapun.');
        }
        $archive = Archive::where('village_id', $village->id)
            ->where('type', 'general')
            ->findOrFail($id);
        return view('admin-desa.archives.edit-general', compact('archive', 'village'));
    }

    public function updateGeneralArchive(Request $request, $id)
    {
        $user = Auth::user();
        $village = $user->villages()->first();
        
        if (!$village) {
            return redirect()->route('login')->with('error', 'Anda tidak terikat dengan desa manapun.');
        }

        $archive = Archive::where('village_id', $village->id)
                         ->where('type', 'general')
                         ->findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $archive->update([
            'title' => $request->title,
            'category' => $request->category,
            'description' => $request->description,
        ]);

        return redirect()->route('admin-desa.archives.archives.general')->with('success', 'Dokumen berhasil diperbarui');
    }

    public function destroyGeneralArchive($id)
    {
        $user = Auth::user();
        $village = $user->villages()->first();
        
        if (!$village) {
            return redirect()->route('login')->with('error', 'Anda tidak terikat dengan desa manapun.');
        }

        $archive = Archive::where('village_id', $village->id)
                         ->where('type', 'general')
                         ->findOrFail($id);

        // Delete file from storage
        if (file_exists(storage_path('app/public/archives/general/' . $archive->file))) {
            unlink(storage_path('app/public/archives/general/' . $archive->file));
        }

        $archive->delete();

        return redirect()->route('admin-desa.archives.archives.general')->with('success', 'Dokumen berhasil dihapus');
    }

    public function governmentStructure()
    {
        $user = Auth::user();
        $village = $user->villages()->first();
        if (!$village) {
            return redirect()->route('login')->with('error', 'Anda tidak terikat dengan desa manapun.');
        }
        return view('admin-desa.government-structure', compact('village'));
    }

    public function updateGovernmentStructure(Request $request)
    {
        $user = Auth::user();
        $village = $user->villages()->first();
        if (!$village) {
            return redirect()->route('login')->with('error', 'Anda tidak terikat dengan desa manapun.');
        }
        $request->validate([
            'head_name' => 'required|string|max:255',
        ]);
        $village->head_name = $request->head_name;
        $village->save();
        return redirect()->route('admin-desa.government-structure')->with('success', 'Nama Kepala Desa berhasil disimpan.');
    }
} 