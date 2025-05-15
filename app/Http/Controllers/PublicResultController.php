<?php

namespace App\Http\Controllers;

use App\Models\AraAlternative;
use App\Models\AraCriteria;
use App\Models\AraEvaluation;
use Illuminate\Http\Request;

class PublicResultController extends Controller
{
    /**
     * Tampilkan hasil perhitungan ARAS untuk user publik.
     */
    public function index()
    {
        // Ambil data
        $alternatives = AraAlternative::all();
        $criterias    = AraCriteria::all();
        $evaluations  = AraEvaluation::all();

        // Jika data kurang, tampilkan pesan
        if ($alternatives->isEmpty() || $criterias->isEmpty() || $evaluations->isEmpty()) {
            $message = 'Data belum lengkap: pastikan ada Kriteria, Alternatif, dan Evaluasi.';
            return view('public.results', compact('message'));
        }

        // 1. Bangun matriks X (+ideal baris 0)
        $X = []; $x0 = [];
        foreach ($evaluations as $ev) {
            $i = $ev->id_alternative;
            $j = $ev->id_criteria;
            $val = $ev->value;

            // inisialisasi x0[j]
            if (!isset($x0[$j])) {
                $x0[$j] = ($criterias->find($j)->attribute=='cost') ? INF : 0;
            }
            // update ideal
            if ($criterias->find($j)->attribute=='cost') {
                $x0[$j] = min($x0[$j], $val);
            } else {
                $x0[$j] = max($x0[$j], $val);
            }

            $X[$i][$j] = $val;
        }
        $X[0] = $x0;

        // 2. Hitung sum_j untuk normalisasi
        $sum_j = [];
        foreach ($X as $i=>$row) {
            foreach ($row as $j=>$xij) {
                $sum_j[$j] = ($sum_j[$j] ?? 0)
                           + (($criterias->find($j)->attribute=='cost')
                               ? (1/$xij) : $xij);
            }
        }

        // 3. Matriks R & D serta skor S
        $D = []; $S = [];
        foreach ($X as $i=>$row) {
            foreach ($row as $j=>$xij) {
                $rij = ($criterias->find($j)->attribute=='cost')
                     ? ((1/$xij)/$sum_j[$j])
                     : ($xij/$sum_j[$j]);
                $D[$i][$j] = $rij * $criterias->find($j)->weight;
            }
            $S[$i] = array_sum($D[$i]);
        }

        // 4. Utilitas K, abaikan baris ideal (i=0)
        $results = [];
        foreach ($S as $i => $si) {
            if ($i != 0) {
                $results[$i] = $si / $S[0];
            }
        }

        // 5. Urutkan descending dan bangun array akhir
        arsort($results);
        $final = [];
        foreach ($results as $i => $ratio) {
            $final[] = [
                'alternative_name' => $alternatives->find($i)->name,
                'score'            => round($ratio, 4),
            ];
        }

        return view('public.results', ['results' => $final]);
    }
}
