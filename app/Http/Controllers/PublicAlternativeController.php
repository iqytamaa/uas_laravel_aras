<?php

namespace App\Http\Controllers;

use App\Models\AraAlternative;
use Illuminate\Http\Request;

class PublicAlternativeController extends Controller
{
    /**
     * Tampilkan daftar alternatif untuk user (read-only).
     */
    public function index()
    {
        $alternatives = AraAlternative::all();
        return view('public.alternative', compact('alternatives'));
    }
}
