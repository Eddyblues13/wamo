<x-layout title="Security — Fintriva" description="How Fintriva protects your money and data: insured custody, encryption and 24/7 monitoring.">

    <x-page-hero
        eyebrow="Security"
        title='Your assets, <span class="text-gradient">fully protected</span>'
        subtitle="Bank-grade security is built into everything we do — from cold-storage custody to round-the-clock monitoring." />

    <section class="py-16">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ([['🧊','Cold-storage custody','The vast majority of assets are held offline, out of reach of attackers.'],['🔐','256-bit encryption','Your data is encrypted in transit and at rest, end to end.'],['🛡️','$250k insurance','Eligible balances are protected by custodial insurance.'],['👁️','24/7 monitoring','Automated fraud detection watches every transaction in real time.'],['🔑','Biometric & 2FA','Face ID, fingerprint and two-factor authentication on every account.'],['✅','Regulated & compliant','We operate under strict regulatory and KYC/AML standards.']] as [$icon, $title, $desc])
                    <div class="reveal rounded-3xl glass p-7" data-delay="{{ ($loop->index % 3) * 80 }}">
                        <div class="text-3xl">{{ $icon }}</div>
                        <h3 class="mt-4 text-lg font-bold">{{ $title }}</h3>
                        <p class="mt-2 text-sm text-white/60">{{ $desc }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="pb-24">
        <div class="mx-auto max-w-3xl px-6 text-center lg:px-8">
            <div class="reveal rounded-3xl glass p-10">
                <h2 class="text-2xl font-bold">Found a vulnerability?</h2>
                <p class="mt-3 text-white/60">We run a responsible disclosure program and reward researchers who help keep Fintriva safe.</p>
                <a href="mailto:security@fintriva.com" class="btn-glow mt-6 inline-flex rounded-full px-7 py-3 text-sm font-semibold">Report to security@fintriva.com</a>
            </div>
        </div>
    </section>

    <x-cta />

</x-layout>
