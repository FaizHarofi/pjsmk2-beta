@props([
    'name',
    'label' => null,
    'current' => null,
    'accept' => 'image/*',
    'required' => false,
    'help' => null,
])

@php
    $id = 'img-' . $name;
    $currentUrl = $current ? asset('storage/' . $current) : null;
@endphp

<div>
    @if($label)
        <label for="{{ $id }}" class="block text-sm font-semibold text-slate-700 mb-1.5">{{ $label }}</label>
    @endif

    <div class="flex items-start gap-4">
        <div class="shrink-0">
            <div id="{{ $id }}-preview" class="w-24 h-24 rounded-lg border border-slate-200 bg-slate-50 overflow-hidden flex items-center justify-center">
                @if($currentUrl)
                    <img src="{{ $currentUrl }}" class="w-full h-full object-cover">
                @else
                    <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                @endif
            </div>
        </div>

        <div class="flex-1">
            <input type="file" id="{{ $id }}" name="{{ $name }}" accept="{{ $accept }}" {{ $required ? 'required' : '' }}
                onchange="window.handleImagePreview(this, '{{ $id }}-preview')"
                class="block w-full text-sm text-slate-700 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-sky-50 file:text-sky-700 file:font-semibold hover:file:bg-sky-100 border border-slate-200 rounded-lg cursor-pointer">

            <div id="{{ $id }}-info" class="mt-1.5 text-xs text-slate-500 hidden">
                <span class="font-mono" id="{{ $id }}-size"></span>
                <span class="text-slate-400">→</span>
                <span class="text-emerald-600 font-semibold">WebP</span>
                <span class="text-slate-400">setelah upload (auto-resize + compress)</span>
            </div>

            @if($current)
                <div class="mt-1.5 text-xs text-slate-500 truncate">
                    <span class="font-semibold">Saat ini:</span> <code class="text-slate-600">{{ $current }}</code>
                </div>
            @endif

            @if($help)
                <p class="mt-1.5 text-xs text-slate-500">{{ $help }}</p>
            @endif
        </div>
    </div>
</div>

@once
@push('scripts')
<script>
    window.handleImagePreview = function(input, previewId) {
        const preview = document.getElementById(previewId);
        const info = document.getElementById(input.id + '-info');
        const sizeEl = document.getElementById(input.id + '-size');

        if (input.files && input.files[0]) {
            const file = input.files[0];
            const reader = new FileReader();
            reader.onload = e => {
                preview.innerHTML = '<img src="' + e.target.result + '" class="w-full h-full object-cover">';
            };
            reader.readAsDataURL(file);

            const kb = (file.size / 1024).toFixed(1);
            sizeEl.textContent = file.name + ' (' + kb + ' KB)';
            info.classList.remove('hidden');
        }
    };
</script>
@endpush
@endonce
