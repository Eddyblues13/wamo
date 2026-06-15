<x-layout title="About — Wamo" description="Wamo is on a mission to make professional-grade investing accessible to everyone, everywhere.">

    <x-page-hero
        eyebrow="About us"
        title='Investing for <span class="text-gradient">everyone</span>'
        subtitle="We're building the wealth platform we always wanted — powerful enough for pros, simple enough for first-timers." />

    <section class="py-16">
        <div class="mx-auto grid max-w-7xl grid-cols-2 gap-8 px-6 lg:grid-cols-4 lg:px-8">
            @foreach ([['2019', 'Founded'],['240K+', 'Investors'],['$12.4B', 'Assets'],['180+', 'Countries']] as [$num, $label])
                <div class="reveal text-center" data-delay="{{ $loop->index * 80 }}">
                    <p class="text-4xl font-black text-gradient sm:text-5xl">{{ $num }}</p>
                    <p class="mt-2 text-sm text-white/60">{{ $label }}</p>
                </div>
            @endforeach
        </div>
    </section>

    <section class="py-16">
        <div class="mx-auto max-w-3xl px-6 text-center lg:px-8">
            <x-section-heading title="Our mission" />
            <p class="reveal mt-6 text-lg leading-relaxed text-white/65">
                For too long, the best investment tools were locked behind high minimums, opaque fees and intimidating jargon.
                Wamo tears down those walls. We bring crypto, global stocks, forex and real estate into one beautifully simple
                app — with bank-grade security and zero hidden costs — so anyone can build wealth with confidence.
            </p>
        </div>
    </section>

    <section class="pb-24">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <x-section-heading eyebrow="What we stand for" title="Our values" />
            <div class="mt-12 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ([['🔍','Radical transparency','Clear fees, honest risk disclosures, no fine-print surprises.'],['🛡️','Security first','Your assets are protected like they were our own.'],['🤝','Customer obsession','Every decision starts with what is best for our investors.'],['⚡','Relentless speed','We ship fast and never stop improving.'],['🌍','Access for all','World-class investing, available in 180+ countries.'],['📚','Empowerment','We teach as much as we enable.']] as [$icon, $title, $desc])
                    <div class="reveal rounded-3xl glass p-7" data-delay="{{ ($loop->index % 3) * 80 }}">
                        <div class="text-3xl">{{ $icon }}</div>
                        <h3 class="mt-4 text-lg font-bold">{{ $title }}</h3>
                        <p class="mt-2 text-sm text-white/60">{{ $desc }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <x-cta title='Join us on the <span class="text-gradient">journey</span>' subtitle="Open an account or come build the future of investing with our team." />

</x-layout>
