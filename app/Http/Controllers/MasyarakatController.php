<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Citizen;
use App\Models\LetterRequest;
use App\Models\LetterType;
use App\Models\Village;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\LetterField;
use App\Services\LetterGenerationService;
use Carbon\Carbon;

class MasyarakatController extends Controller
{
    protected $letterGenerationService;
    
    public function __construct(LetterGenerationService $letterGenerationService)
    {
        $this->letterGenerationService = $letterGenerationService;
    }

    public function dashboard()
    {
        $user = Auth::user();
        $citizen = $user->citizen;
        $village = $citizen ? $citizen->village : null;
        return view('masyarakat.dashboard', compact('citizen', 'village'));
    }

    public function profile()
    {
        $user = Auth::user();
        $citizen = $user->citizen;
        $village = $citizen ? $citizen->village : null;
        return view('masyarakat.profile', compact('citizen', 'village'));
    }

    public function letterForm(Request $request)
    {
        $user = Auth::user();
        $citizen = $user->citizen;
        $village = $citizen ? $citizen->village : null;
        $letterTypes = LetterType::where('is_active', 1)->get();
        $resubmitRequest = null;
        $selectedTypeId = $request->letter_type_id;
        $fields = collect();
        $citizenFields = [
            'nik', 'kk_number', 'name', 'birth_place', 'birth_date', 'address', 'phone', 'email',
            'gender', 'religion', 'marital_status', 'education', 'job', 'nationality'
        ];
        if ($request->resubmit_id) {
            $resubmitRequest = LetterRequest::where('citizen_id', $citizen->id)
                ->where('id', $request->resubmit_id)
                ->where('status', 'rejected')
                ->first();
            if ($resubmitRequest) {
                $selectedTypeId = $resubmitRequest->letter_type_id;
            }
        }
        if ($village && $selectedTypeId) {
            $fields = LetterField::where('village_id', $village->id)
                ->where('letter_type_id', $selectedTypeId)
                ->orderBy('order')
                ->get();
        }
        return view('masyarakat.letter-form', compact('citizen', 'village', 'letterTypes', 'fields', 'selectedTypeId', 'citizenFields', 'resubmitRequest'));
    }

    public function submitLetter(Request $request)
    {
        $user = Auth::user();
        $citizen = $user->citizen;
        $village = $citizen ? $citizen->village : null;
        
        $request->validate([
            'letter_type_id' => 'required|exists:letter_types,id',
            'purpose' => 'required|string',
        ]);

        // Validasi field dinamis
        $fields = LetterField::where('letter_type_id', $request->letter_type_id)->get();
        $dynamicRules = [];
        foreach ($fields as $field) {
            if ($field->is_required) {
                $dynamicRules['fields.' . $field->field_name] = 'required';
            }
        }
        $request->validate($dynamicRules);

        // Generate nomor urut per desa per tahun
        $currentYear = date('Y');
        $nomorUrut = LetterRequest::where('village_id', $village->id)
            ->whereYear('created_at', $currentYear)
            ->count() + 1;

        // Generate request number
        $requestNumber = 'REQ-' . date('Ymd') . '-' . str_pad(LetterRequest::whereDate('created_at', today())->count() + 1, 4, '0', STR_PAD_LEFT);

        // Get letter type
        $letterType = LetterType::find($request->letter_type_id);
        
        // Simpan data dinamis
        $formData = $request->input('fields', []);

        LetterRequest::create([
            'village_id' => $village->id,
            'citizen_id' => $citizen->id,
            'letter_type_id' => $request->letter_type_id,
            'request_number' => $requestNumber,
            'letter_name' => $letterType->name,
            'applicant_name' => $citizen->name,
            'applicant_nik' => $citizen->nik,
            'applicant_kk' => $citizen->kk_number,
            'purpose' => $request->purpose,
            'phone' => $citizen->phone,
            'address' => $citizen->address,
            'data' => json_encode($formData),
            'status' => 'pending',
            'nomor_urut' => $nomorUrut, // simpan nomor urut otomatis
            // Mapping field dinamis ke kolom khusus
            'domicile_address' => $formData['domicile_address'] ?? null,
            'keterangan' => $formData['keterangan'] ?? null,
            'keperluan' => $formData['keperluan'] ?? null,
            'deceased_name' => $formData['deceased_name'] ?? null,
            'deceased_age' => $formData['deceased_age'] ?? null,
            'deceased_nik' => $formData['deceased_nik'] ?? null,
            'deceased_gender' => $formData['deceased_gender'] ?? null,
            'deceased_address' => $formData['deceased_address'] ?? null,
            'death_day' => $formData['death_day'] ?? null,
            'death_date' => $formData['death_date'] ?? null,
            'death_place' => $formData['death_place'] ?? null,
            'death_cause' => $formData['death_cause'] ?? null,
        ]);

        return redirect()->route('masyarakat.letters.status')->with('success', 'Permohonan surat berhasil diajukan. Silakan cek status surat Anda.');
    }

    public function lettersStatus()
    {
        $user = Auth::user();
        $citizen = $user->citizen;
        $village = $citizen ? $citizen->village : null;
        $requests = LetterRequest::where('citizen_id', $citizen->id)->with(['letterType'])->orderByDesc('created_at')->get();
        return view('masyarakat.letters-status', compact('citizen', 'village', 'requests'));
    }

    public function downloadLetter($id)
    {
        $user = Auth::user();
        $citizen = $user->citizen;
        $village = $citizen ? $citizen->village : null;
        $request = LetterRequest::where('citizen_id', $citizen->id)->with(['letterType', 'citizen'])->findOrFail($id);
        
        if ($request->status !== 'approved') {
            return back()->with('error', 'Surat hanya bisa diunduh jika sudah disetujui.');
        }
        
        // Generate letter content using service
        $letterContent = $this->letterGenerationService->generateLetterContent($request, $citizen, $village);
        
        // Create PDF
        $pdf = Pdf::loadHTML($letterContent);
        $filename = 'Surat_' . ($request->letterType->name ?? 'Administrasi') . '_' . $citizen->name . '.pdf';
        
        return $pdf->download($filename);
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $citizen = $user->citizen;
        $validated = $request->validate([
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:32',
        ]);

        $citizen->update($validated);
        return redirect()->route('masyarakat.profile')->with('success', 'Profil berhasil diperbarui.');
    }

    public function resubmitLetter($id)
    {
        $user = Auth::user();
        $citizen = $user->citizen;
        $oldRequest = LetterRequest::where('citizen_id', $citizen->id)
            ->where('id', $id)
            ->where('status', 'rejected')
            ->firstOrFail();

        // Generate nomor urut per desa per tahun
        $currentYear = date('Y');
        $nomorUrut = LetterRequest::where('village_id', $oldRequest->village_id)
            ->whereYear('created_at', $currentYear)
            ->count() + 1;

        // Generate new request number
        $requestNumber = 'REQ-' . date('Ymd') . '-' . str_pad(LetterRequest::whereDate('created_at', today())->count() + 1, 4, '0', STR_PAD_LEFT);

        $newRequest = $oldRequest->replicate();
        $newRequest->status = 'pending';
        $newRequest->request_number = $requestNumber;
        $newRequest->nomor_urut = $nomorUrut;
        $newRequest->notes = null;
        $newRequest->created_at = now();
        $newRequest->updated_at = now();
        $newRequest->save();

        return redirect()->route('masyarakat.letters.status')->with('success', 'Permohonan surat berhasil diajukan ulang. Silakan cek status surat Anda.');
    }
} 