<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman;

class PengumumanController extends Controller
{
    public function index()
    {
        $pengumumen = Pengumuman::published()->notExpired()->latest('published_at')->paginate(10);
        return view('public.pengumuman.index', compact('pengumumen'));
    }
}
