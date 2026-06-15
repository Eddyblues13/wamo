{{-- ============ HOW IT WORKS ============ --}}
<section id="how" class="py-24">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <x-section-heading eyebrow="Getting started" title="Begin investing in three steps" />

        <div class="mt-16 grid gap-8 md:grid-cols-3">
            @php
                $steps = [
                    ['01', 'Open your account', 'Register in minutes and complete secure identity verification.'],
                    ['02', 'Fund your account', 'Deposit instantly by card, bank transfer or cryptocurrency, fee-free.'],
                    ['03', 'Build your portfolio', 'Allocate across digital assets, equities and forex, and monitor performance in real time.'],
                ];
            @endphp
            @foreach ($steps as [$n, $title, $desc])
                <div class="reveal relative rounded-3xl glass p-8" data-delay="{{ $loop->index * 120 }}">
                    <span class="text-5xl font-black text-white/10">{{ $n }}</span>
                    <h3 class="mt-3 text-xl font-bold">{{ $title }}</h3>
                    <p class="mt-2 text-white/60">{{ $desc }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>
