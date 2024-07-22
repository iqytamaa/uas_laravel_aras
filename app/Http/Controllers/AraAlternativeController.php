<?php

namespace App\Http\Controllers;

use App\Models\AraAlternative;
use Illuminate\Http\Request;

class AraAlternativeController extends Controller
{
    public function index()
    {
        $alternatives = AraAlternative::all();
        return view('alternative', compact('alternatives'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'alternative_name' => 'required',
        ]);

        AraAlternative::create([
            'name' => $request->alternative_name,
        ]);

        return redirect()->back()->with('success', 'Alternatif berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'alternative_name' => 'required',
        ]);

        $alternative = AraAlternative::findOrFail($id);
        $alternative->update([
            'name' => $request->alternative_name,
        ]);

        return redirect()->back()->with('success', 'Alternatif berhasil diperbarui!');
    }

    public function destroy($id)
    {
        AraAlternative::destroy($id);
        return redirect()->back()->with('success', 'Alternatif berhasil dihapus!');
    }
}
