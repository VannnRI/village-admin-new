<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\LetterRequest;
use App\Services\LetterGenerationService;
use Barryvdh\DomPDF\Facade\Pdf;

class PerangkatDesaController extends Controller
{
    protected $letterGenerationService;

    public function __construct(LetterGenerationService $letterGenerationService)
    {
        $this->letterGenerationService = $letterGenerationService;
    }

    public function dashboard()
    {
        $user = Auth::user();
        $village = $user->villages()->first();
        $pending = LetterRequest::where('village_id', $village->id)->where('status', 'pending')->count();
        $approved = LetterRequest::where('village_id', $village->id)->where('status', 'approved')->count();
        $rejected = LetterRequest::where('village_id', $village->id)->where('status', 'rejected')->count();
        return view('perangkat-desa.dashboard', compact('village', 'pending', 'approved', 'rejected'));
    }

    public function letterRequests(Request $request)
    {
        $user = Auth::user();
        $village = $user->villages()->first();
        $query = \App\Models\LetterRequest::where('village_id', $village->id)->with(['citizen', 'letterType']);
        if ($request->q) {
            $q = $request->q;
            $query->where(function($sub) use ($q) {
                $sub->where('applicant_name', 'like', "%$q%")
                    ->orWhere('applicant_nik', 'like', "%$q%")
                    ->orWhereHas('letterType', function($q2) use ($q) {
                        $q2->where('name', 'like', "%$q%") ;
                    })
                    ->orWhere('status', 'like', "%$q%") ;
            });
        }
        $requests = $query->orderByDesc('created_at')->get();
        $totalLetterRequests = \App\Models\LetterRequest::where('village_id', $village->id)->count();
        return view('perangkat-desa.letter-requests.index', compact('village', 'requests', 'totalLetterRequests'));
    }

    public function showLetterRequest($id)
    {
        $user = Auth::user();
        $village = $user->villages()->first();
        $request = LetterRequest::where('village_id', $village->id)->with(['citizen', 'letterType'])->findOrFail($id);
        // Ambil data dinamis (isian masyarakat)
        $dynamicFields = $request->data ? json_decode($request->data, true) : [];
        // Ambil field dinamis dari LetterType
        $fields = $request->letterType ? $request->letterType->fields()->orderBy('order')->get() : collect();
        return view('perangkat-desa.letter-requests.show', compact('village', 'request', 'dynamicFields', 'fields'));
    }

    public function approveLetterRequest($id)
    {
        $user = Auth::user();
        $village = $user->villages()->first();
        $request = LetterRequest::where('village_id', $village->id)->findOrFail($id);
        $request->status = 'approved';
        $request->approved_by = $user->id;
        $request->approved_at = now();
        $request->save();
        return redirect()->route('perangkat-desa.letter-requests')->with('success', 'Permohonan surat disetujui.');
    }

    public function rejectLetterRequest(Request $request, $id)
    {
        $user = Auth::user();
        $village = $user->villages()->first();
        $letterRequest = LetterRequest::where('village_id', $village->id)->findOrFail($id);
        $request->validate([
            'notes' => 'required|string|max:1000',
        ]);
        $letterRequest->status = 'rejected';
        $letterRequest->approved_by = $user->id;
        $letterRequest->notes = $request->notes;
        $letterRequest->save();
        return redirect()->route('perangkat-desa.letter-requests')->with('success', 'Permohonan surat ditolak.');
    }

    public function downloadLetter($id)
    {
        $user = Auth::user();
        $village = $user->villages()->first();
        $request = \App\Models\LetterRequest::where('village_id', $village->id)->with(['citizen', 'letterType'])->findOrFail($id);
        if ($request->status !== 'approved') {
            return back()->with('error', 'Surat hanya bisa diunduh jika sudah disetujui.');
        }
        // Generate letter content using service
        $letterContent = $this->letterGenerationService->generateLetterContent($request, $request->citizen, $village);
        // Create PDF
        $pdf = Pdf::loadHTML($letterContent);
        $filename = 'Surat_' . ($request->letterType->name ?? 'Administrasi') . '_' . $request->citizen->name . '.pdf';
        return $pdf->download($filename);
    }

    public function profile()
    {
        return view('perangkat-desa.profile');
    }

    public function updateUsername(Request $request)
    {
        $request->validate([
            'new_username' => 'required|string|unique:users,username,' . Auth::id(),
            'current_password' => 'required'
        ]);

        $user = Auth::user();
        
        // Verify current password
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini salah.']);
        }

        $user->update(['username' => $request->new_username]);

        return redirect()->route('perangkat-desa.profile')->with('success', 'Username berhasil diubah');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password_pw' => 'required',
            'new_password' => 'required|string|min:6|confirmed'
        ]);

        $user = Auth::user();
        
        // Verify current password
        if (!Hash::check($request->current_password_pw, $user->password)) {
            return back()->withErrors(['current_password_pw' => 'Password saat ini salah.']);
        }

        $user->update(['password' => Hash::make($request->new_password)]);

        return redirect()->route('perangkat-desa.profile')->with('success', 'Password berhasil diubah');
    }
} 