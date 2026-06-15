<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Guru;

class GuruController extends Controller
{
    public function index()
    {
        $gurus = Guru::active()->with('jurusan')->ordered()->get();
        return view('public.gurus.index', compact('gurus'));
    }
}
