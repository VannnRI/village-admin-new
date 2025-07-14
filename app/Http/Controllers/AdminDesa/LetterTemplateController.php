<?php

namespace App\Http\Controllers\AdminDesa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LetterType;
use App\Models\LetterField;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Services\LetterGenerationService;
use Barryvdh\DomPDF\Facade\Pdf;

class LetterTemplateController extends Controller
{
    protected $letterGenerationService;
    
    public function __construct(LetterGenerationService $letterGenerationService)
    {
        $this->letterGenerationService = $letterGenerationService;
    }

    public function index()
    {
        $user = Auth::user();
        $village = $user->villages()->first();
        $templates = LetterType::where(function($q) use ($village) {
            $q->where('village_id', $village->id)
              ->orWhereNull('village_id');
        })->withCount('fields')->get();

        return view('admin-desa.letter-templates.index', compact('templates'));
    }

    public function create()
    {
        return view('admin-desa.letter-templates.create');
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $village = $user->villages()->first();

        $request->validate([
            'name' => 'required|string|max:255',
            'processing_days' => 'required|integer|min:1',
        ]);

        $letterType = LetterType::create([
            'village_id' => $village->id,
            'name' => $request->name,
            'processing_days' => $request->processing_days,
            'template_html' => $request->template_html,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        // Simpan field dinamis jika ada
        if ($request->fields_json) {
            $fields = json_decode($request->fields_json, true);
            if (is_array($fields)) {
                foreach ($fields as $i => $field) {
                    if (!empty($field['name'])) {
                        LetterField::create([
                            'village_id' => $village->id,
                            'letter_type_id' => $letterType->id,
                            'field_name' => $field['name'],
                            'field_label' => $field['label'] ?? $field['name'],
                            'field_type' => $field['type'] ?? 'text',
                            'field_options' => $field['options'] ?? null,
                            'is_required' => !empty($field['required']) ? 1 : 0,
                            'order' => $i + 1,
                        ]);
                    }
                }
            }
        }

        return redirect()->route('admin-desa.letter-templates.index')->with('success', 'Template surat berhasil dibuat.');
    }

    public function edit($id)
    {
        $user = Auth::user();
        $village = $user->villages()->first();
        $template = LetterType::where('id', $id)
            ->where(function($q) use ($village) {
                $q->where('village_id', $village->id)
                  ->orWhereNull('village_id');
            })
            ->firstOrFail();

        $fieldsForJs = $template->fields->map(function($f) {
            return [
                'name' => $f->field_name,
                'label' => $f->field_label,
                'type' => $f->field_type,
                'required' => (bool)$f->is_required,
                'options' => $f->field_options,
            ];
        });
        return view('admin-desa.letter-templates.edit', compact('template', 'fieldsForJs'));
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $village = $user->villages()->first();
        $template = LetterType::where('id', $id)
            ->where(function($q) use ($village) {
                $q->where('village_id', $village->id)
                  ->orWhereNull('village_id');
            })
            ->firstOrFail();

        $request->validate([
            'name' => 'required|string|max:255',
            'processing_days' => 'required|integer|min:1',
            'template_html' => 'nullable|string',
        ]);

        $template->update([
            'name' => $request->name,
            'processing_days' => $request->processing_days,
            'template_html' => $request->template_html,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        // Update field dinamis
        if ($request->fields_json !== null) {
            // Hapus field lama
            $template->fields()->delete();
            $fields = json_decode($request->fields_json, true);
            if (is_array($fields)) {
                foreach ($fields as $i => $field) {
                    if (!empty($field['name'])) {
                        LetterField::create([
                            'village_id' => $village->id,
                            'letter_type_id' => $template->id,
                            'field_name' => $field['name'],
                            'field_label' => $field['label'] ?? $field['name'],
                            'field_type' => $field['type'] ?? 'text',
                            'field_options' => $field['options'] ?? null,
                            'is_required' => !empty($field['required']) ? 1 : 0,
                            'order' => $i + 1,
                        ]);
                    }
                }
            }
        }

        return redirect()->route('admin-desa.letter-templates.edit', $template->id)->with('success', 'Template surat berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $user = Auth::user();
        $village = $user->villages()->first();
        $template = LetterType::where('id', $id)
            ->where(function($q) use ($village) {
                $q->where('village_id', $village->id)
                  ->orWhereNull('village_id');
            })
            ->firstOrFail();
        $template->delete();

        return redirect()->route('admin-desa.letter-templates.index')->with('success', 'Template surat berhasil dihapus.');
    }

    public function preview($id)
    {
        $template = \App\Models\LetterType::with('fields')->findOrFail($id);

        // Data dummy default
        $dummy = [
            'name' => 'Budi Santoso',
            'nik' => '3524010301870001',
            'kk_number' => '1234567890123456',
            'birth_place' => 'Lamongan',
            'birth_date' => '01-01-1987',
            'address' => 'Jl. Contoh No. 123',
            'phone' => '081234567890',
            'email' => 'budi@example.com',
            'gender' => 'Laki-laki',
            'religion' => 'Islam',
            'marital_status' => 'Menikah',
            'education' => 'S1',
            'job' => 'Karyawan Swasta',
            'nationality' => 'Indonesia',
            'nama_desa' => 'Warungering',
            'alamat_desa' => 'Jl. Desa No. 1',
            'telepon_desa' => '0322-123456',
            'email_desa' => 'desa@contoh.com',
            'kode_desa' => '', // kosongkan agar tidak dobel di preview
            'kode_pos' => '62272',
            'kecamatan' => 'Kedungpring',
            'kabupaten' => 'Lamongan',
            'jenis_surat' => $template->name,
            'nomor_surat' => '001/WRG/2024',
            'tanggal_surat' => date('d-m-Y'),
            'bulan' => 'Juli',
            'bulan_romawi' => 'VII',
            'tahun' => '', // kosongkan agar tidak dobel di preview
            'nomor_urut' => '001',
            'purpose' => 'Keperluan Administrasi',
        ];

        // Tambahkan data dummy untuk setiap field dinamis
        foreach ($template->fields as $field) {
            if (!isset($dummy[$field->field_name])) {
                $dummy[$field->field_name] = 'Contoh ' . $field->field_label;
            }
        }

        // Ambil data desa
        $user = \Auth::user();
        $village = $user ? $user->villages()->first() : null;
        // Generate nomor surat dummy sesuai format profil desa
        $nomorSuratDummy = '001';
        if ($village && $village->number_format) {
            $replace = [
                'nomor_urut' => '001',
                'kode_desa' => $village->village_code ?? 'WRG',
                'bulan_romawi' => 'VII',
                'tahun' => date('Y'),
                'jenis_surat' => $template->name,
            ];
            $nomorSuratDummy = $village->number_format;
            foreach ($replace as $key => $val) {
                $nomorSuratDummy = str_replace('{{ '.$key.' }}', $val, $nomorSuratDummy);
            }
        }
        $dummy['nomor_surat'] = $nomorSuratDummy;

        // Pastikan kode_desa dan tahun dummy tetap diisi agar preview tidak kosong
        $dummy['kode_desa'] = $village->village_code ?? 'WRG';
        $dummy['tahun'] = date('Y');

        // Ambil perangkat desa dari database
        $user = \Auth::user();
        $village = $user ? $user->villages()->first() : null;
        if ($village) {
            $officials = \App\Models\VillageOfficial::where('village_id', $village->id)->get();
            foreach ($officials as $official) {
                $key = strtolower(str_replace([' ', '.'], '_', $official->position));
                $dummy[$key . '_nama'] = $official->name;
                $dummy[$key . '_nip'] = $official->nip;
            }
        }
        // Gantikan variabel di template dengan data dummy
        $html = $template->template_html;
        foreach ($dummy as $key => $value) {
            $html = str_replace('{{ '.$key.' }}', $value, $html);
            $html = str_replace('@{{ '.$key.' }}', $value, $html); // untuk blade escape
        }

        return view('admin-desa.letter-templates.preview', compact('html'));
    }

    public function downloadLetter($id)
    {
        $user = Auth::user();
        $village = $user->villages()->first();
        $request = \App\Models\LetterRequest::with(['citizen', 'letterType'])->findOrFail($id);
        
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
} 