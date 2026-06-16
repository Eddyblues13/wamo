@props([
    'code' => '',
    'title' => 'Something went wrong',
    'message' => 'An unexpected error occurred.',
    'emoji' => '🧭',
])

<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $code ? $code.' — ' : '' }}Wamo</title>
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-ink-950 text-white font-sans antialiased">

    <div class="pointer-events-none fixed inset-0 -z-10 overflow-hidden">
        <div class="absolute -top-40 left-1/2 h-[34rem] w-[34rem] -translate-x-1/2 rounded-full bg-brand/20 blur-[120px]"></div>
        <div class="absolute bottom-0 right-0 h-[26rem] w-[26rem] rounded-full bg-violet/15 blur-[120px]"></div>
    </div>

    <main class="relative flex min-h-screen flex-col items-center justify-center overflow-hidden px-6 text-center">
        <div class="absolute inset-0 -z-10 bg-grid"></div>

        <a href="{{ url('/') }}" class="mb-10"><x-logo /></a>

        <div class="scene-3d animate-float text-7xl sm:text-8xl">{{ $emoji }}</div>

        @if ($code)
            <p class="mt-6 text-6xl font-black tracking-tight text-gradient sm:text-7xl">{{ $code }}</p>
        @endif

        <h1 class="mt-4 text-2xl font-black tracking-tight sm:text-3xl">{{ $title }}</h1>
        <p class="mt-3 max-w-md text-white/60">{{ $message }}</p>

        <div class="mt-9 flex flex-col items-center gap-4 sm:flex-row">
            <a href="{{ url('/') }}" data-magnetic class="btn-glow inline-flex items-center gap-2 rounded-full px-7 py-3.5 text-base font-semibold">
                Back to homepage
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6 6 6-6 6"/></svg>
            </a>
            <div class="flex items-center gap-3">
                <a href="{{ route('user.dashboard') }}" class="rounded-full glass px-5 py-3 text-sm font-semibold text-white/90 transition hover:bg-white/10">Dashboard</a>
                <a href="{{ route('login') }}" class="rounded-full glass px-5 py-3 text-sm font-semibold text-white/90 transition hover:bg-white/10">Sign in</a>
            </div>
        </div>

        <p class="mt-10 text-xs text-white/30">Need help? Contact <a href="mailto:support@wamointernational.com" class="text-white/50 hover:text-white">support@wamointernational.com</a></p>
    </main>

</body>
</html>
