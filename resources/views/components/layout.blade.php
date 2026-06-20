@props([
    'title' => 'Wamo — Invest in Crypto, Tesla, Stocks & Forex',
    'description' => 'Wamo is the modern wealth platform to invest in crypto, Tesla & global stocks, real estate and trade forex — all from one secure, professional dashboard.',
])

<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }}</title>
    <meta name="description" content="{{ $description }}">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @include('partials.smartsupp')
</head>
<body class="bg-ink-950 text-white font-sans antialiased overflow-x-hidden">

    {{-- Scroll progress bar --}}
    <div id="scroll-progress"></div>

    {{-- Ambient background glows --}}
    <div class="pointer-events-none fixed inset-0 -z-10 overflow-hidden">
        <div class="absolute -top-40 -left-40 h-[40rem] w-[40rem] rounded-full bg-brand/25 blur-[120px] animate-pulse-glow" style="animation:aurora 16s ease-in-out infinite"></div>
        <div class="absolute top-1/3 -right-40 h-[36rem] w-[36rem] rounded-full bg-violet/25 blur-[120px] animate-pulse-glow" style="animation:aurora 20s ease-in-out infinite reverse;animation-delay:1.2s"></div>
        <div class="absolute bottom-0 left-1/3 h-[32rem] w-[32rem] rounded-full bg-emerald/15 blur-[120px] animate-pulse-glow" style="animation:aurora 24s ease-in-out infinite;animation-delay:2.4s"></div>
    </div>

    @include('partials.navbar')

    <main>
        {{ $slot }}
    </main>

    @include('partials.footer')
    @include('partials.translator')
    @include('partials.toasts')

</body>
</html>
