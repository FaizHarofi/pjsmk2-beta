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
    $currentUrl = $current ? asset('uploads/' . $current) : null;
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

    <div class="flex items-center gap-3">
        <div class="shrink-0 w-20 h-20 rounded-lg border border-slate-200 bg-slate-50 overflow-hidden relative group">
            <img id="{{ $id }}-preview" src="{{ $currentUrl ?: '' }}" class="w-full h-full object-cover {{ $currentUrl ? '' : 'hidden' }}">
            <div id="{{ $id }}-placeholder" class="w-full h-full flex items-center justify-center text-slate-300 {{ $currentUrl ? 'hidden' : '' }}">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/></svg>
            </div>
            <button type="button" x-show="hasCurrent" @click="clearImage()" class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 flex items-center justify-center text-white text-xs font-semibold transition">
                <span class="flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3"/></svg>
                    Hapus
                </span>
            </button>
        </div>
        <div class="flex-1 min-w-0">
            <input type="file" accept="image/*" @change="onChange" {{ $required ? 'required' : '' }}
                class="block w-full text-sm text-slate-700 file:mr-2 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:bg-sky-50 file:text-sky-700 file:font-semibold file:text-xs hover:file:bg-sky-100 border border-slate-200 rounded-md cursor-pointer">
            <input type="hidden" name="{{ $name }}" id="{{ $id }}-hidden" value="{{ $current }}">

            <div class="flex items-center gap-2 mt-1.5 text-xs">
                <template x-if="info">
                    <span class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded bg-emerald-50 text-emerald-700 font-semibold">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        WebP
                    </span>
                </template>
                <span x-show="info" x-text="info" class="text-slate-600"></span>
            </div>

            <p class="text-[11px] text-slate-400 mt-1">Resize <span class="font-mono font-semibold text-slate-500">{{ $outputW }}{{ $outputH ? '×'.$outputH : 'px' }}</span> → WebP otomatis</p>
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
        get hasCurrent() {
            const h = document.getElementById(cfg.id + '-hidden');
            return h && h.value;
        },
        clearImage() {
            if (!confirm('Hapus gambar ini?')) return;
            const preview = document.getElementById(cfg.id + '-preview');
            const placeholder = document.getElementById(cfg.id + '-placeholder');
            const hidden = document.getElementById(cfg.id + '-hidden');
            preview.src = '';
            preview.classList.add('hidden');
            placeholder.classList.remove('hidden');
            hidden.value = '';
            this.info = '';
        },
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
