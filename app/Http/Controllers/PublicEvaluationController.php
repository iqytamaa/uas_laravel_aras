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
        // Mengambil data kriteria dan alternatif untuk ditampilkan pada form evaluasi
        $criterias = AraCriteria::all();
        $alternatives = AraAlternative::all();
        $evaluations = AraEvaluation::all();

        // Mengirim data ke view untuk menampilkan form evaluasi
        return view('public.evaluation', compact('criterias', 'alternatives', 'evaluations'));
    }

    /**
     * Proses input evaluasi dari user
     */
    public function submit(Request $request)
    {
        // Mendapatkan data evaluasi dari form input
        $data = $request->input('evaluations', []);

        // Melakukan proses untuk menyimpan atau memperbarui evaluasi setiap alternatif dan kriteria
        foreach ($data as $altId => $critVals) {
            foreach ($critVals as $critId => $value) {
                AraEvaluation::updateOrCreate(
                    ['id_alternative' => $altId, 'id_criteria' => $critId],
                    ['value' => $value]
                );
            }
        }

        // Redirect user ke halaman hasil evaluasi
        return redirect()->route('user.results.index');
    }
}
