<?php

namespace App\Http\Controllers;

use App\Models\AraCriteria;
use Illuminate\Http\Request;

class PublicCriteriaController extends Controller
{
    /**
     * Tampilkan daftar kriteria untuk user (read-only).
     */
    public function index()
    {
        $criterias = AraCriteria::all();
        return view('public.criteria', compact('criterias'));
    }
}
