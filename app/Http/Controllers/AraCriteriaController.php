<?php

namespace App\Http\Controllers;

use App\Models\AraCriteria;
use Illuminate\Http\Request;

class AraCriteriaController extends Controller
{
    // Tampilkan daftar kriteria
    public function index()
    {
        $criterias = AraCriteria::all(); // ambil semua data kriteria
        return view('admin.criteria', data: compact('criterias')); // kirim ke view 'criteria.blade.php'
    }

    // Simpan kriteria baru
  public function store(Request $request)
{
    $request->validate([
        'criteria_name' => 'required',
        'criteria_attribute' => 'required',
        'criteria_weight' => 'required|numeric|gt:0',
    ], [
        'criteria_name.required' => 'Nama kriteria wajib diisi.',
        'criteria_attribute.required' => 'Atribut kriteria wajib diisi.',
        'criteria_weight.required' => 'Bobot kriteria wajib diisi.',
        'criteria_weight.numeric' => 'Bobot kriteria harus berupa angka.',
        'criteria_weight.gt' => 'Bobot kriteria harus lebih besar dari 0 dan tidak boleh 0 atau negatif.',
    ]);

    AraCriteria::create([
        'criteria' => $request->criteria_name,
        'attribute' => $request->criteria_attribute,
        'weight' => $request->criteria_weight,
    ]);

    return redirect()->back()->with('success', 'Kriteria berhasil ditambahkan!');
}
public function update(Request $request, $id)
{
    $request->validate([
        'criteria_name' => 'required',
        'criteria_attribute' => 'required',
        'criteria_weight' => 'required|numeric|gt:0', // harus > 0
    ]);

    $criteria = AraCriteria::findOrFail($id);

    $criteria->update([
        'criteria' => $request->criteria_name,
        'attribute' => $request->criteria_attribute,
        'weight' => $request->criteria_weight,
    ]);

    return redirect()->back()->with('success', 'Kriteria berhasil diperbarui!');
}


    // Hapus kriteria
    public function destroy($id)
    {
        AraCriteria::destroy($id);
        return redirect()->back()->with('success', 'Kriteria berhasil dihapus!');
    }
}
