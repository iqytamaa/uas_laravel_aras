<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AraAlternative;
use App\Models\AraCriteria;
use App\Models\AraEvaluation;

class DssController extends Controller
{
    public function calculate()
    {
        // Inisialisasi variabel array alternatif
        $alternatif = AraAlternative::all()->pluck('name', 'id_alternative')->toArray();
        if (empty($alternatif)) {
            return view('results', ['message' => 'Tidak ada alternatif yang tersedia untuk perhitungan.']);
        }

        // Inisialisasi variabel array kriteria dan bobot (W)
        $kriteria = AraCriteria::all();
        $kriterias = [];
        $w = [];
        foreach ($kriteria as $row) {
            $kriterias[$row->id_criteria] = [$row->name, $row->attribute];
            $w[$row->id_criteria] = $row->weight;
        }

        if (empty($kriterias)) {
            return view('results', ['message' => 'Tidak ada kriteria yang tersedia untuk perhitungan.']);
        }

        // Inisialisasi variabel array matriks keputusan X
        $X = [];
        $x_0 = [];
        $evaluations = AraEvaluation::all();
        foreach ($evaluations as $row) {
            $i = $row->id_alternative;
            $j = $row->id_criteria;
            $aij = $row->value;

            if (!isset($x_0[$j])) {
                $x_0[$j] = ($kriterias[$j][1] == 'cost') ? 10 : 0;
            }
            $x_0[$j] = ($kriterias[$j][1] == 'cost') ? min($x_0[$j], $aij) : max($x_0[$j], $aij);
            $X[$i][$j] = $aij;
        }

        if (empty($X)) {
            return view('results', ['message' => 'Tidak ada evaluasi yang tersedia untuk perhitungan.']);
        }

        // Menambahkan data alternatif optimum pada index=0
        $X[0] = $x_0;

        // Inisialisasi jumlah nilai per kriteria (sum_j)
        $sum_j = [];
        foreach ($X as $i => $xi) {
            foreach ($xi as $j => $xij) {
                if (!isset($sum_j[$j])) {
                    $sum_j[$j] = 0;
                }
                $sum_j[$j] += ($kriterias[$j][1] == 'cost') ? (1 / $xij) : $xij;
            }
        }

        // Inisialisasi variabel array matriks Normalisasi (R)
        $R = [];
        foreach ($X as $i => $xi) {
            foreach ($xi as $j => $xij) {
                $R[$i][$j] = ($kriterias[$j][1] == 'cost') ? ((1 / $xij) / $sum_j[$j]) : ($xij / $sum_j[$j]);
            }
        }

        // Inisialisasi variabel array matriks ternormalisasi terbobot (D)
        $D = [];
        foreach ($R as $i => $ri) {
            foreach ($ri as $j => $rij) {
                $D[$i][$j] = $rij * $w[$j];
            }
        }

        // Inisialisasi variabel array nilai fungsi optimum (S)
        $S = [];
        foreach ($D as $i => $di) {
            $S[$i] = array_sum($di);
        }

        // Inisialisasi variabel array nilai utilitas (K)
        $K = [];
        foreach ($S as $i => $si) {
            if ($i != 0) {
                $K[$i] = $si / $S[0];
            }
        }

        if (empty($K)) {
            return view('results', ['message' => 'Tidak ada hasil perhitungan yang tersedia.']);
        }

        // Menampilkan alternatif terpilih
        arsort($K);
        $pilih = key($K);
        $nilai = reset($K);

        return view('results', compact('K', 'alternatif', 'pilih', 'nilai'));
    }
}