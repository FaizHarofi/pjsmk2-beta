<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Fasilitas;
use App\Models\Sekolah;

class ProfilController extends Controller
{
    public function sejarah()
    {
        $sekolah = Sekolah::first();
        return view('public.profil.sejarah', compact('sekolah'));
    }

    public function visiMisi()
    {
        $sekolah = Sekolah::first();
        return view('public.profil.visi-misi', compact('sekolah'));
    }

    public function fasilitas()
    {
        $fasilitas = Fasilitas::active()->ordered()->get();
        return view('public.profil.fasilitas', compact('fasilitas'));
    }
}
