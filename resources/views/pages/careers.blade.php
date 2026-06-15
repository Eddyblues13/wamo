<x-layout title="Careers — Wamo" description="Join Wamo and help build the future of investing. Remote-first, mission-driven.">

    <x-page-hero
        eyebrow="Careers"
        title='Build the future of <span class="text-gradient">finance</span>'
        subtitle="We're a remote-first team of engineers, designers and finance nerds on a mission to democratize investing.">
        <x-slot:actions>
            <a href="#openings" class="btn-glow rounded-full px-7 py-3.5 text-base font-semibold">View open roles</a>
        </x-slot:actions>
    </x-page-hero>

    <section class="py-16">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <x-section-heading eyebrow="Perks & benefits" title="Why you'll love it here" />
            <div class="mt-12 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ([['🌍','Remote-first','Work from anywhere in the world.'],['🏖️','Unlimited PTO','Rest when you need it, no questions asked.'],['💰','Equity for all','Share in the upside you help create.'],['🩺','Full health cover','Medical, dental and vision, globally.'],['📚','Learning budget','$2,000/yr to grow your skills.'],['💻','Top gear','Latest hardware and a home-office stipend.'],['🧘','Wellness stipend','Gym, therapy, whatever keeps you sharp.'],['✈️','Team retreats','We meet up in great places twice a year.']] as [$icon, $title, $desc])
                    <div class="reveal rounded-3xl glass p-6" data-delay="{{ ($loop->index % 4) * 70 }}">
                        <div class="text-3xl">{{ $icon }}</div>
                        <h3 class="mt-3 font-bold">{{ $title }}</h3>
                        <p class="mt-1 text-sm text-white/55">{{ $desc }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section id="openings" class="pb-24">
        <div class="mx-auto max-w-4xl px-6 lg:px-8">
            <x-section-heading eyebrow="We're hiring" title="Open positions" />
            <div class="mt-12 space-y-3">
                @php
                    $jobs = [
                        ['Senior Backend Engineer', 'Engineering', 'Remote', 'Full-time'],
                        ['Product Designer', 'Design', 'Remote', 'Full-time'],
                        ['Compliance Officer', 'Legal', 'London', 'Full-time'],
                        ['Growth Marketer', 'Marketing', 'Remote', 'Full-time'],
                        ['Customer Success Lead', 'Support', 'Remote', 'Full-time'],
                    ];
                @endphp
                @foreach ($jobs as [$role, $team, $loc, $type])
                    <a href="{{ route('register') }}" class="reveal flex flex-col gap-3 rounded-2xl glass p-6 transition hover:bg-white/[0.07] sm:flex-row sm:items-center sm:justify-between" data-delay="{{ $loop->index * 60 }}">
                        <div>
                            <h3 class="font-bold">{{ $role }}</h3>
                            <p class="mt-1 text-sm text-white/50">{{ $team }} · {{ $loc }} · {{ $type }}</p>
                        </div>
                        <span class="inline-flex items-center gap-1.5 text-sm font-semibold text-brand-bright">Apply
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6 6 6-6 6"/></svg>
                        </span>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

</x-layout>
