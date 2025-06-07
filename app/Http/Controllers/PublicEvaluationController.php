<?php

namespace App\Http\Controllers;

use App\Models\AraEvaluation;
use App\Models\AraCriteria;
use App\Models\AraAlternative;
use Illuminate\Http\Request;

class PublicEvaluationController extends Controller
{
    /**
     * Tampilkan form evaluasi publik
     */
    public function showForm()
    {
        // Mengambil data kriteria, alternatif, dan evaluasi (jika ada)
        $criterias    = AraCriteria::all();
        $alternatives = AraAlternative::all();
        $evaluations  = AraEvaluation::all();

        // Memanggil view: resources/views/public/evaluation.blade.php
        return view('public.evaluation', compact('criterias', 'alternatives', 'evaluations'));
    }

    /**
     * Proses input evaluasi dari user
     */
    public function submit(Request $request)
    {
        // 1. Validasi: pastikan semua input evaluasi berupa angka (integer atau desimal)
        $request->validate([
            'evaluations.*.*' => 'required|numeric',
        ]);

        // 2. Ambil data evaluasi dari form
        $data = $request->input('evaluations', []);

        // 3. Simpan atau perbarui masing-masing evaluasi
        foreach ($data as $altId => $critVals) {
            foreach ($critVals as $critId => $value) {
                AraEvaluation::updateOrCreate(
                    [
                        'id_alternative' => $altId,
                        'id_criteria'    => $critId,
                    ],
                    ['value' => $value]
                );
            }
        }

        // 4. Redirect user ke halaman hasil evaluasi dengan pesan sukses
        return redirect()->route('user.results.index')
                         ->with('success', 'Evaluasi berhasil disubmit!');
    }
}
