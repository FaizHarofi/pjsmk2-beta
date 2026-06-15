<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\KategoriVideo;
use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function index(Request $request)
    {
        $query = Video::published()->with('kategori');

        if ($request->filled('kategori')) {
            $query->where('kategori_video_id', $request->kategori);
        }

        $videos = $query->ordered()->paginate(9);
        $kategoris = KategoriVideo::active()->get();

        return view('public.videos.index', compact('videos', 'kategoris'));
    }
}
