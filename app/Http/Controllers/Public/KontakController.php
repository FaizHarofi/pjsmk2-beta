<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\KontakPesan;
use App\Models\Sekolah;
use Illuminate\Http\Request;

class KontakController extends Controller
{
    public function index()
    {
        $sekolah = Sekolah::first();
        return view('public.kontak', compact('sekolah'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subjek' => 'nullable|string|max:255',
            'pesan' => 'required|string',
        ]);

        $validated['ip_address'] = $request->ip();

        KontakPesan::create($validated);

        return back()->with('success', 'Pesan Anda telah terkirim. Terima kasih!');
    }
}
