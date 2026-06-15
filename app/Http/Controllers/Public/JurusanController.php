<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;

class JurusanController extends Controller
{
    public function index()
    {
        $jurusans = Jurusan::active()->ordered()->get();
        return view('public.jurusans.index', compact('jurusans'));
    }

    public function show(Jurusan $jurusan)
    {
        abort_unless($jurusan->is_active, 404);
        $jurusan->load('ketuaJurusan', 'gurus', 'prestasis');
        return view('public.jurusans.show', compact('jurusan'));
    }
}
