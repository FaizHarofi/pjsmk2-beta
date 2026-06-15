<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriVideo;
use App\Models\Video;
use App\Traits\AjaxResponse;
use App\Traits\HasImageUpload;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    use HasImageUpload, AjaxResponse;

    public function index()
    {
        $videos = Video::with('kategori')->ordered()->paginate(15);
        return view('admin.videos.index', compact('videos'));
    }

    public function create()
    {
        $kategoris = KategoriVideo::all();
        return view('admin.videos.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'kategori_video_id' => 'nullable|exists:kategori_videos,id',
            'deskripsi' => 'nullable|string',
            'youtube_url' => 'required|url',
            'is_published' => 'boolean',
            'is_featured' => 'boolean',
            'urutan' => 'nullable|integer',
        ]);

        $validated['is_published'] = $request->boolean('is_published');
        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['user_id'] = auth()->id();
        $validated['youtube_embed'] = youtube_embed($validated['youtube_url']);
        $validated['thumbnail'] = youtube_thumbnail($validated['youtube_url']);

        if ($validated['is_published'] && !$request->input('published_at')) {
            $validated['published_at'] = now();
        }

        Video::create($validated);

        return redirect()->route('admin.videos.index')->with('success', 'Video berhasil ditambahkan.');
    }

    public function edit(Video $video)
    {
        $kategoris = KategoriVideo::all();
        return view('admin.videos.edit', compact('video', 'kategoris'));
    }

    public function update(Request $request, Video $video)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'kategori_video_id' => 'nullable|exists:kategori_videos,id',
            'deskripsi' => 'nullable|string',
            'youtube_url' => 'required|url',
            'is_published' => 'boolean',
            'is_featured' => 'boolean',
            'urutan' => 'nullable|integer',
        ]);

        $validated['is_published'] = $request->boolean('is_published');
        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['youtube_embed'] = youtube_embed($validated['youtube_url']);
        $validated['thumbnail'] = youtube_thumbnail($validated['youtube_url']);

        $video->update($validated);

        return redirect()->route('admin.videos.index')->with('success', 'Video berhasil diperbarui.');
    }

    public function destroy(Video $video)
    {
        $video->delete();
        return redirect()->route('admin.videos.index')->with('success', 'Video berhasil dihapus.');
    }

    public function togglePublish(Request $request, Video $video)
    {
        $video->update([
            'is_published' => !$video->is_published,
            'published_at' => !$video->is_published ? now() : $video->published_at,
        ]);
        if ($this->wantsJson($request)) {
            return $this->jsonSuccess('Status publish diperbarui.', ['is_published' => $video->is_published]);
        }
        return back()->with('success', 'Status video diperbarui.');
    }
}
