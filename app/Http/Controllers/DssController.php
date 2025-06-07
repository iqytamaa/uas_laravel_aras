<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AraAlternative;
use App\Models\AraCriteria;
use App\Models\AraEvaluation;

class DssController extends Controller
{
    /**
     * Hitung dan tampilkan hasil DSS (metode ARAS).
     */
    public function calculate()
    {
        // 1) Ambil alternatif [id => name]
        $alternatif = AraAlternative::all()
            ->pluck('name', 'id_alternative')
            ->toArray();

        if (empty($alternatif)) {
            return view('admin.results', [
                'message' => 'Tidak ada alternatif tersedia.'
            ]);
        }

        // 2) Ambil kriteria: bobot & attribute
        $kriteria = AraCriteria::all();
        $w    = []; // bobot
        $attr = []; // benefit/cost
        foreach ($kriteria as $k) {
            $w[$k->id_criteria]    = $k->weight;
            $attr[$k->id_criteria] = $k->attribute;
        }

        // 3) Bangun matriks X dan cari ideal x0
        $X  = []; // X[i][j]
        $x0 = []; // X0[j]
        foreach (AraEvaluation::all() as $ev) {
            $i   = $ev->id_alternative;
            $j   = $ev->id_criteria;
            $val = $ev->value;

            if (!isset($x0[$j])) {
                $x0[$j] = ($attr[$j] === 'cost') ? INF : 0;
            }
            if ($attr[$j] === 'cost') {
                $x0[$j] = min($x0[$j], $val);
            } else {
                $x0[$j] = max($x0[$j], $val);
            }

            $X[$i][$j] = $val;
        }
        // sisipkan baris ideal (index 0)
        $X[0] = $x0;

        // 4) Hitung sum_j untuk normalisasi
        $sumj = [];
        foreach ($X as $i => $row) {
            foreach ($row as $j => $xij) {
                $sumj[$j] = ($sumj[$j] ?? 0)
                          + ($attr[$j] === 'cost' ? 1/$xij : $xij);
            }
        }

        // 5) Matriks normalisasi R
        $R = [];
        foreach ($X as $i => $row) {
            foreach ($row as $j => $xij) {
                $R[$i][$j] = ($attr[$j] === 'cost')
                    ? ((1/$xij) / $sumj[$j])
                    : ($xij / $sumj[$j]);
            }
        }

        // 6) Matriks berbobot D
        $D = [];
        foreach ($R as $i => $row) {
            foreach ($row as $j => $rij) {
                $D[$i][$j] = $rij * $w[$j];
            }
        }

        // 7) Hitung Sᵢ
        $S = [];
        foreach ($D as $i => $row) {
            $S[$i] = array_sum($row);
        }

        // 8) Hitung utilitas Kᵢ = Sᵢ / S₀
        $K = [];
        foreach ($S as $i => $si) {
            if ($i !== 0) {
                $K[$i] = $si / $S[0];
            }
        }

        // 9) Urutkan & ambil pemenang
        arsort($K);

        if (empty($K)) {
    return redirect()->back()->with('error', 'Perhitungan gagal karena semua skor kosong. Pastikan semua data evaluasi telah lengkap.');
}

        $winnerId    = array_key_first($K);
        $winnerScore = $K[$winnerId];

        return view('admin.results', [
            'alternatif'   => $alternatif,
            'criteria'     => $kriteria,
            'X'            => $X,
            'R'            => $R,
            'D'            => $D,
            'S'            => $S,
            'K'            => $K,
            'winnerId'     => $winnerId,
            'winnerScore'  => $winnerScore,
        ]);
    }
}
