<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KontakPesan;
use App\Traits\AjaxResponse;
use Illuminate\Http\Request;

class KontakController extends Controller
{
    use AjaxResponse;

    public function index()
    {
        $pesans = KontakPesan::latest()->paginate(15);
        $unreadCount = KontakPesan::where('is_read', false)->count();
        return view('admin.kontak.index', compact('pesans', 'unreadCount'));
    }

    public function show(KontakPesan $kontak)
    {
        if (!$kontak->is_read) {
            $kontak->update(['is_read' => true]);
        }
        return view('admin.kontak.show', compact('kontak'));
    }

    public function markRead(Request $request, KontakPesan $kontak)
    {
        $kontak->update(['is_read' => !$kontak->is_read]);
        if ($this->wantsJson($request)) {
            return $this->jsonSuccess('Status pesan diperbarui.', [
                'is_read' => $kontak->is_read,
                'unread_count' => KontakPesan::where('is_read', false)->count(),
            ]);
        }
        return back()->with('success', 'Status pesan diperbarui.');
    }

    public function destroy(Request $request, KontakPesan $kontak)
    {
        $kontak->delete();
        if ($this->wantsJson($request)) {
            return $this->jsonSuccess('Pesan dihapus.', [
                'unread_count' => KontakPesan::where('is_read', false)->count(),
            ]);
        }
        return redirect()->route('admin.kontak.index')->with('success', 'Pesan berhasil dihapus.');
    }

    public function unreadCount()
    {
        return $this->jsonSuccess('OK', [
            'unread_count' => KontakPesan::where('is_read', false)->count(),
        ]);
    }
}
