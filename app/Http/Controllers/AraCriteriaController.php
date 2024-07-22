<?php

namespace App\Http\Controllers;

use App\Models\AraCriteria;
use Illuminate\Http\Request;

class AraCriteriaController extends Controller
{
    public function index()
    {
        $criterias = AraCriteria::all();
        return view('your_view_name', compact('criterias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'criteria_name' => 'required',
            'criteria_attribute' => 'required',
            'criteria_weight' => 'required|numeric',
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
            'criteria_weight' => 'required|numeric',
        ]);

        $criteria = AraCriteria::findOrFail($id);
        $criteria->update([
            'criteria' => $request->criteria_name,
            'attribute' => $request->criteria_attribute,
            'weight' => $request->criteria_weight,
        ]);

        return redirect()->back()->with('success', 'Kriteria berhasil diperbarui!');
    }

    public function destroy($id)
    {
        AraCriteria::destroy($id);
        return redirect()->back()->with('success', 'Kriteria berhasil dihapus!');
    }
}
