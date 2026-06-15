<x-layout title="Blog — Wamo" description="Insights on investing, crypto, stocks and forex from the Wamo team.">

    <x-page-hero
        eyebrow="Blog"
        title='Insights to <span class="text-gradient">invest smarter</span>'
        subtitle="Guides, market analysis and product news from the Wamo team." />

    <section class="py-16">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="grid gap-6 lg:grid-cols-3">
                @php
                    $posts = [
                        ['Beginner', 'How to build your first diversified portfolio', 'A step-by-step guide to spreading risk across crypto, stocks and more.', 'https://images.unsplash.com/photo-1579621970563-ebec7560ff3e?auto=format&fit=crop&w=900&q=80'],
                        ['Crypto', 'Staking explained: earn while you hold', 'Everything you need to know about earning passive yield on your crypto.', 'https://images.unsplash.com/photo-1621761191319-c6fb62004040?auto=format&fit=crop&w=900&q=80'],
                        ['Stocks', 'Why fractional shares changed investing', 'Own a piece of Tesla or Amazon without buying a whole share.', 'https://images.unsplash.com/photo-1611974789855-9c2a0a7236a3?auto=format&fit=crop&w=900&q=80'],
                        ['Forex', 'Managing risk with leverage', 'Use leverage responsibly with these five practical rules.', 'https://images.unsplash.com/photo-1535320903710-d993d3d77d29?auto=format&fit=crop&w=900&q=80'],
                        ['Markets', 'Reading the 2026 macro landscape', 'What rates, inflation and AI mean for your portfolio this year.', 'https://images.unsplash.com/photo-1590283603385-17ffb3a7f29f?auto=format&fit=crop&w=900&q=80'],
                        ['Product', "What's new in the Wamo app", 'A roundup of the latest features and improvements.', 'https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?auto=format&fit=crop&w=900&q=80'],
                    ];
                @endphp
                @foreach ($posts as [$tag, $title, $excerpt, $img])
                    <a href="#" class="reveal group overflow-hidden rounded-3xl glass transition hover:bg-white/[0.07]" data-delay="{{ ($loop->index % 3) * 80 }}">
                        <div class="relative h-44 overflow-hidden bg-gradient-to-br from-brand/40 to-violet/30">
                            <img src="{{ $img }}" alt="{{ $title }}" loading="lazy" referrerpolicy="no-referrer" onerror="this.style.display='none'" class="h-full w-full object-cover opacity-75 transition duration-500 group-hover:scale-105">
                        </div>
                        <div class="p-6">
                            <span class="text-xs font-semibold uppercase tracking-wider text-brand-bright">{{ $tag }}</span>
                            <h3 class="mt-2 text-lg font-bold leading-snug">{{ $title }}</h3>
                            <p class="mt-2 text-sm text-white/55">{{ $excerpt }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <x-cta title='Put these ideas <span class="text-gradient">to work</span>' />

</x-layout>
