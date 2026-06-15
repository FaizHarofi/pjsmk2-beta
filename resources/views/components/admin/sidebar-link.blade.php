@props(['href' => '#', 'icon' => 'circle'])

<a href="{{ $href }}" {{ $attributes->merge(['class' => 'flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-colors ' . (request()->fullUrlIs($href . '*') ? 'bg-white/20 text-white' : 'text-white/70 hover:bg-white/10 hover:text-white')]) }}>
    <span class="w-5 h-5 flex items-center justify-center">
        @switch($icon)
            @case('home') 🏠 @break
            @case('newspaper') 📰 @break
            @case('building') 🏫 @break
            @case('academic-cap') 👨‍🏫 @break
            @case('play-circle') 🎥 @break
            @case('photograph') 🖼️ @break
            @case('users') 👥 @break
            @case('trophy') 🏆 @break
            @case('speakerphone') 📢 @break
            @case('star') ⚽ @break
            @case('library') 🏛️ @break
            @case('cog') ⚙️ @break
            @case('link') 🔗 @break
            @case('mail') 📬 @break
            @case('user-group') 👤 @break
            @default ●
        @endswitch
    </span>
    {{ $slot }}
</a>
