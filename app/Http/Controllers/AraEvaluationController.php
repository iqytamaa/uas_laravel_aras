<?php

namespace App\Http\Controllers;

use App\Models\AraAlternative;
use App\Models\AraCriteria;
use App\Models\AraEvaluation;
use Illuminate\Http\Request;

class AraEvaluationController extends Controller
{
    /**
     * Tampilkan form dan data evaluasi untuk admin.
     */
    public function index()
    {
        $alternatives = AraAlternative::all();
        $criterias    = AraCriteria::all();
        $evaluations  = AraEvaluation::all();

        // Memanggil view: resources/views/admin/evaluation.blade.php
        return view('admin.evaluation', compact('alternatives', 'criterias', 'evaluations'));
    }

    /**
     * Bulk update evaluasi berdasarkan input matrix dari admin.
     */
  public function update(Request $request)
{
    $request->validate([
        'evaluations.*.*' => 'required|numeric|gt:0',
    ], [
        'evaluations.*.*.gt' => 'Nilai evaluasi harus lebih besar dari 0 dan tidak boleh kosong atau negatif.',
    ]);

    $data = $request->input('evaluations', []);

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

    return redirect()->route('evaluation.index')
                     ->with('success', 'Evaluasi berhasil diperbarui!');
}



    /**
     * Hapus satu record evaluasi.
     */
    public function destroy($id)
    {
        AraEvaluation::destroy($id);

        return redirect()->route('evaluation.index')
                         ->with('success', 'Evaluasi berhasil dihapus!');
    }
}
