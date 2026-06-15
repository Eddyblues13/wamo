@props([
    'wordmark' => true,
    'iconClass' => 'h-9 w-9 drop-shadow-[0_6px_16px_rgba(124,92,255,0.35)]',
])

@php $gid = 'wamo-'.\Illuminate\Support\Str::random(6); @endphp

<span {{ $attributes->merge(['class' => 'inline-flex items-center gap-2.5']) }}>
    <svg class="{{ $iconClass }}" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Wamo">
        <defs>
            <linearGradient id="{{ $gid }}" x1="2" y1="2" x2="38" y2="38" gradientUnits="userSpaceOnUse">
                <stop stop-color="#5B8CFF"/>
                <stop offset="0.55" stop-color="#7C5CFF"/>
                <stop offset="1" stop-color="#B254FF"/>
            </linearGradient>
        </defs>
        <rect x="1.5" y="1.5" width="37" height="37" rx="11" fill="url(#{{ $gid }})"/>
        <rect x="1.5" y="1.5" width="37" height="37" rx="11" fill="#ffffff" fill-opacity="0.05"/>
        {{-- upward "growth" line that reads as a W --}}
        <path d="M9 24.5 L14.5 29 L20 18.5 L25.5 27 L31 11.5" stroke="#ffffff" stroke-width="2.8" stroke-linecap="round" stroke-linejoin="round"/>
        <circle cx="31" cy="11.5" r="2.7" fill="#3FE0A8"/>
    </svg>

    @if ($wordmark)
        <span class="text-xl font-bold tracking-tight">Wamo</span>
    @endif
</span>
