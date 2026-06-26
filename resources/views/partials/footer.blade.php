@php
    $footerCols = [
        'Invest' => [
            ['Crypto', route('crypto')],
            ['Stocks & Tesla', route('stocks')],
            ['Forex', route('forex')],
            ['Real Estate', route('real-estate')],
        ],
        'Company' => [
            ['About', route('about')],
            ['Careers', route('careers')],
            ['Press', route('press')],
            ['Blog', route('blog')],
        ],
        'Legal' => [
            ['Privacy', route('privacy')],
            ['Terms', route('terms')],
            ['Security', route('security')],
            ['Disclosures', route('disclosures')],
        ],
    ];
@endphp

<footer class="border-t border-white/5 py-12">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <div class="grid gap-10 md:grid-cols-2 lg:grid-cols-5">
            <div class="lg:col-span-2">
                <a href="{{ route('home') }}" aria-label="Fintriva home">
                    <x-logo />
                </a>
                <p class="mt-4 max-w-sm text-sm text-white/50">The modern wealth platform for crypto, stocks, real estate and forex. Invest with confidence.</p>
            </div>
            @foreach ($footerCols as $heading => $links)
                <div>
                    <h4 class="text-sm font-semibold text-white">{{ $heading }}</h4>
                    <ul class="mt-4 space-y-3">
                        @foreach ($links as [$label, $href])
                            <li><a href="{{ $href }}" class="text-sm text-white/50 transition hover:text-white">{{ $label }}</a></li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>
        <div class="mt-12 flex flex-col items-center justify-between gap-4 border-t border-white/5 pt-8 text-sm text-white/40 sm:flex-row">
            <p>© {{ date('Y') }} Fintriva. All rights reserved.</p>
            <p>Investing involves risk. Capital at risk.</p>
        </div>
    </div>
</footer>
