@props([
    'name',
    'folder',
    'label' => null,
    'current' => null,
    'aspect' => '16/9',
    'outputW' => 1200,
    'outputH' => null,
    'quality' => 0.85,
    'required' => false,
    'extra' => null,
])

@php
    $id = 'crop-' . md5($name . $folder);
    $currentUrl = $current ? asset('storage/' . $current) : null;
    $ratio = $outputH ? "{$outputW}/{$outputH}" : $aspect;
@endphp

@once
@push('head')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css">
@endpush
@endonce

<div x-data="imageCropper({
    folder: '{{ $folder }}',
    name: '{{ $name }}',
    id: '{{ $id }}',
    aspect: '{{ $ratio }}',
    outputW: {{ $outputW }},
    outputH: {{ $outputH ?: 'null' }},
    quality: {{ $quality }},
    extra: {{ $extra ? json_encode($extra) : '{}' }}
})" x-cloak class="image-cropper-wrapper">

    @if($label)
        <label class="block text-sm font-semibold text-slate-700 mb-1.5">
            {{ $label }}
            @if($required)<span class="text-red-500">*</span>@endif
        </label>
    @endif

    <div class="flex items-start gap-4">
        <div class="shrink-0 w-24 h-24 rounded-lg border border-slate-200 bg-slate-50 overflow-hidden relative">
            <img id="{{ $id }}-preview" src="{{ $currentUrl ?: '' }}" class="w-full h-full object-cover {{ $currentUrl ? '' : 'hidden' }}">
            <div id="{{ $id }}-placeholder" class="w-full h-full flex items-center justify-center text-slate-300 {{ $currentUrl ? 'hidden' : '' }}">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
        </div>
        <div class="flex-1 space-y-2">
            <input type="file" accept="image/*" @change="onChange" {{ $required ? 'required' : '' }}
                class="block w-full text-sm text-slate-700 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-sky-50 file:text-sky-700 file:font-semibold hover:file:bg-sky-100 border border-slate-200 rounded-lg cursor-pointer">
            <input type="hidden" name="{{ $name }}" id="{{ $id }}-hidden" value="{{ $current }}">

            <div x-show="info" class="text-xs flex items-center gap-2">
                <span class="px-2 py-0.5 rounded bg-emerald-50 text-emerald-700 font-semibold">WebP</span>
                <span x-text="info" class="text-slate-600"></span>
            </div>

            <p class="text-xs text-slate-500">Akan di-resize ke <span class="font-mono font-semibold">{{ $outputW }}{{ $outputH ? '×'.$outputH : 'px max' }}</span> lalu convert ke WebP otomatis.</p>
        </div>
    </div>

    <div id="{{ $id }}-modal" class="fixed inset-0 z-[200] hidden bg-black/70 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-3xl overflow-hidden">
            <div class="p-4 border-b border-slate-200 flex items-center justify-between">
                <div>
                    <h3 class="font-bold text-slate-900">Crop & Resize Gambar</h3>
                    <p class="text-xs text-slate-500">Pilih area yang ingin digunakan, lalu simpan.</p>
                </div>
                <button type="button" @click="closeModal()" class="text-slate-400 hover:text-slate-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div class="p-4 bg-slate-100" style="max-height:60vh;overflow:hidden">
                <img id="{{ $id }}-img" src="" class="block max-w-full">
            </div>
            <div class="p-4 border-t border-slate-200 flex items-center justify-end gap-2">
                <button type="button" @click="closeModal()" class="px-4 py-2 text-sm text-slate-600 hover:bg-slate-100 rounded-lg">Batal</button>
                <button type="button" id="{{ $id }}-btn" @click="save()" :disabled="loading" class="px-5 py-2 text-sm bg-primary text-white rounded-lg hover:bg-sky-800 font-semibold disabled:opacity-60">
                    <span x-show="!loading">Crop & Simpan</span>
                    <span x-show="loading" class="flex items-center gap-2">
                        <svg class="animate-spin w-4 h-4" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                        Memproses...
                    </span>
                </button>
            </div>
        </div>
    </div>
</div>

@once
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('imageCropper', (cfg) => ({
        cropper: null,
        loading: false,
        info: '',
        file: null,
        id: cfg.id,
        async onChange(e) {
            const f = e.target.files[0];
            if (!f) return;
            this.file = f;
            const url = URL.createObjectURL(f);
            const img = document.getElementById(cfg.id + '-img');
            img.src = url;
            document.getElementById(cfg.id + '-modal').classList.remove('hidden');
            await this.$nextTick();
            if (this.cropper) this.cropper.destroy();
            this.cropper = new Cropper(img, {
                aspectRatio: cfg.aspect,
                viewMode: 1,
                background: false,
                autoCropArea: 1,
            });
        },
        closeModal() {
            document.getElementById(cfg.id + '-modal').classList.add('hidden');
            if (this.cropper) { this.cropper.destroy(); this.cropper = null; }
        },
        async save() {
            if (!this.cropper) return;
            this.loading = true;
            try {
                const opts = { imageSmoothingEnabled: true, imageSmoothingQuality: 'high' };
                if (cfg.outputW) opts.width = cfg.outputW;
                if (cfg.outputH) opts.height = cfg.outputH;
                const canvas = this.cropper.getCroppedCanvas(opts);
                const dataUrl = canvas.toDataURL('image/webp', cfg.quality);
                const fd = new FormData();
                fd.append('folder', cfg.folder);
                fd.append('image_data', dataUrl);
                if (cfg.extra) {
                    Object.entries(cfg.extra).forEach(([k, v]) => fd.append(k, v));
                }
                const r = await fetch('/admin/upload/image', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    },
                    body: fd
                });
                const data = await r.json();
                if (data.status === 'success') {
                    const preview = document.getElementById(cfg.id + '-preview');
                    const placeholder = document.getElementById(cfg.id + '-placeholder');
                    const hidden = document.getElementById(cfg.id + '-hidden');
                    preview.src = data.data.url + '?t=' + Date.now();
                    preview.classList.remove('hidden');
                    placeholder.classList.add('hidden');
                    hidden.value = data.data.path;
                    this.info = data.data.size_kb + ' KB';
                    this.closeModal();
                    if (window.AdminAjax) window.AdminAjax.toast(data.message, 'success');
                } else {
                    if (window.AdminAjax) window.AdminAjax.toast(data.message, 'error');
                }
            } catch (err) {
                if (window.AdminAjax) window.AdminAjax.toast('Error: ' + err.message, 'error');
            }
            this.loading = false;
        }
    }));
});
</script>
@endpush
@endonce
