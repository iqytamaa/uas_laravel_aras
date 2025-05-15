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
        // Ambil semua alternatif
        $alternatif = AraAlternative::all()
            ->pluck('name', 'id_alternative')
            ->toArray();

        if (empty($alternatif)) {
            return view('admin.results', [
                'message' => 'Tidak ada alternatif yang tersedia untuk perhitungan.'
            ]);
        }

        // Ambil semua kriteria dan bobot
        $kriteria = AraCriteria::all();
        $kriterias = [];
        $w = [];
        foreach ($kriteria as $row) {
            $kriterias[$row->id_criteria] = [
                'name'      => $row->criteria,
                'attribute' => $row->attribute
            ];
            $w[$row->id_criteria] = $row->weight;
        }

        if (empty($kriterias)) {
            return view('admin.results', [
                'message' => 'Tidak ada kriteria yang tersedia untuk perhitungan.'
            ]);
        }

        // Bangun matriks keputusan X dan cari nilai ideal x₀
        $X = [];
        $x0 = [];
        foreach (AraEvaluation::all() as $ev) {
            $i = $ev->id_alternative;
            $j = $ev->id_criteria;
            $aij = $ev->value;

            // inisialisasi x₀[j]
            if (!isset($x0[$j])) {
                $x0[$j] = ($kriterias[$j]['attribute'] === 'cost') ? INF : 0;
            }
            // update x₀ sesuai attribute
            if ($kriterias[$j]['attribute'] === 'cost') {
                $x0[$j] = min($x0[$j], $aij);
            } else {
                $x0[$j] = max($x0[$j], $aij);
            }

            $X[$i][$j] = $aij;
        }

        if (empty($X)) {
            return view('admin.results', [
                'message' => 'Tidak ada evaluasi yang tersedia untuk perhitungan.'
            ]);
        }

        // sisipkan baris ideal
        $X[0] = $x0;

        // Hitung sum_j untuk normalisasi
        $sum_j = [];
        foreach ($X as $i => $row) {
            foreach ($row as $j => $xij) {
                if (!isset($sum_j[$j])) {
                    $sum_j[$j] = 0;
                }
                $sum_j[$j] += ($kriterias[$j]['attribute'] === 'cost')
                    ? (1 / $xij)
                    : $xij;
            }
        }

        // Matriks normalisasi R
        $R = [];
        foreach ($X as $i => $row) {
            foreach ($row as $j => $xij) {
                $R[$i][$j] = ($kriterias[$j]['attribute'] === 'cost')
                    ? ( (1 / $xij) / $sum_j[$j] )
                    : ( $xij / $sum_j[$j] );
            }
        }

        // Matriks ternormalisasi terbobot D
        $D = [];
        foreach ($R as $i => $row) {
            foreach ($row as $j => $rij) {
                $D[$i][$j] = $rij * $w[$j];
            }
        }

        // Hitung Sᵢ = Σ Dᵢⱼ
        $S = [];
        foreach ($D as $i => $row) {
            $S[$i] = array_sum($row);
        }

        // Hitung utilitas Kᵢ = Sᵢ / S₀ (ideal)
        $K = [];
        foreach ($S as $i => $si) {
            if ($i !== 0) {
                $K[$i] = $si / $S[0];
            }
        }

        if (empty($K)) {
            return view('admin.results', [
                'message' => 'Tidak ada hasil perhitungan yang tersedia.'
            ]);
        }

        // Sort dan ambil pemenang
        arsort($K);
        $pilih = key($K);
        $nilai = reset($K);

        return view('admin.results', compact('K', 'alternatif', 'pilih', 'nilai'));
    }
}
