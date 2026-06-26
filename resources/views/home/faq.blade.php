{{-- ============ FAQ ============ --}}
<section id="faq" class="py-24">
    <div class="mx-auto max-w-3xl px-6 lg:px-8">
        <x-section-heading eyebrow="Questions?" title="Frequently asked" />

        <div class="mt-12 space-y-3">
            @php
                $faqs = [
                    ['Is my money safe with Fintriva?', 'Yes. Assets are held in insured, cold-storage custody with 256-bit encryption, and eligible balances are protected up to $250,000. We never lend out your funds without explicit consent.'],
                    ['How much do I need to start?', 'There is no minimum. You can buy fractional shares of Tesla, Amazon and others — or crypto — from as little as $1, commission-free.'],
                    ['What can I invest in?', 'Crypto (200+ assets), global stocks like Tesla and Amazon, forex (60+ pairs), commodities such as gold, real estate and expert-managed funds — all from one account.'],
                    ['How fast are deposits and withdrawals?', 'Card and crypto deposits are instant. Bank withdrawals typically settle in seconds to a few minutes, 24/7.'],
                    ['Does Fintriva charge fees?', 'A simple flat 0.1% trading fee with no hidden spreads, deposit fees or inactivity charges.'],
                ];
            @endphp
            @foreach ($faqs as [$q, $a])
                <div class="faq-item reveal overflow-hidden rounded-2xl glass" data-faq data-delay="{{ $loop->index * 60 }}">
                    <button type="button" class="flex w-full items-center justify-between gap-4 px-6 py-5 text-left" data-faq-toggle>
                        <span class="font-semibold">{{ $q }}</span>
                        <svg class="faq-icon h-5 w-5 shrink-0 text-brand-bright transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                    </button>
                    <div class="faq-body">
                        <div><p class="px-6 pb-5 text-white/60">{{ $a }}</p></div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
