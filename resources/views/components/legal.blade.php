@props([
    'heading',
    'updated' => null,
])

<x-layout :title="$heading . ' — Fintriva'" :description="$heading . ' for Fintriva, the modern wealth platform.'">

    <x-page-hero
        eyebrow="Legal"
        :title="$heading"
        :subtitle="$updated ? 'Last updated ' . $updated : null" />

    <section class="pb-24">
        <div class="mx-auto max-w-3xl px-6 lg:px-8">
            <div class="reveal space-y-8 leading-relaxed text-white/70 [&_h2]:mt-2 [&_h2]:text-xl [&_h2]:font-bold [&_h2]:text-white [&_p]:mt-3">
                {{ $slot }}
            </div>
            <p class="reveal mt-12 text-sm text-white/40">Questions? Contact <a href="mailto:legal@fintriva.com" class="text-brand-bright hover:underline">legal@fintriva.com</a>.</p>
        </div>
    </section>

</x-layout>
