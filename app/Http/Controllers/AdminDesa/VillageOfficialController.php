<?php

namespace App\Http\Controllers\AdminDesa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VillageOfficial;
use Illuminate\Support\Facades\Auth;

class VillageOfficialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $village = $user->villages()->first();
        $officials = VillageOfficial::where('village_id', $village->id)->get();
        return view('admin-desa.village-officials.index', compact('officials', 'village'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin-desa.village-officials.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $village = $user->villages()->first();
        $request->validate([
            'position' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'nip' => 'nullable|string|max:255',
        ]);
        VillageOfficial::create([
            'village_id' => $village->id,
            'position' => $request->position,
            'name' => $request->name,
            'nip' => $request->nip,
        ]);
        return redirect()->route('admin-desa.village-officials.index')->with('success', 'Perangkat desa berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = Auth::user();
        $village = $user->villages()->first();
        $official = VillageOfficial::where('village_id', $village->id)->findOrFail($id);
        return view('admin-desa.village-officials.edit', compact('official'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $village = $user->villages()->first();
        $official = VillageOfficial::where('village_id', $village->id)->findOrFail($id);
        $request->validate([
            'position' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'nip' => 'nullable|string|max:255',
        ]);
        $official->update([
            'position' => $request->position,
            'name' => $request->name,
            'nip' => $request->nip,
        ]);
        return redirect()->route('admin-desa.village-officials.index')->with('success', 'Perangkat desa berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = Auth::user();
        $village = $user->villages()->first();
        $official = VillageOfficial::where('village_id', $village->id)->findOrFail($id);
        $official->delete();
        return redirect()->route('admin-desa.village-officials.index')->with('success', 'Perangkat desa berhasil dihapus.');
    }
}
