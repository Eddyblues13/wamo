<x-admin-layout title="Investment plans">

    <div class="mb-6 flex items-center justify-between">
        <p class="text-white/55">Manage the investment plans shown to users.</p>
        <a href="{{ route('admin.plans.create') }}" class="btn-glow rounded-2xl px-5 py-2.5 text-sm font-bold text-white">+ New plan</a>
    </div>

    <div class="overflow-hidden rounded-3xl glass">
        <div class="overflow-x-auto">
            <table class="table-cards w-full text-left text-sm">
                <thead class="border-b border-white/10 text-xs uppercase tracking-wider text-white/40">
                    <tr>
                        <th class="px-6 py-4 font-medium">Plan</th>
                        <th class="px-6 py-4 text-right font-medium">ROI</th>
                        <th class="px-6 py-4 text-right font-medium">Range</th>
                        <th class="px-6 py-4 text-right font-medium">Term</th>
                        <th class="px-6 py-4 text-right font-medium">Investors</th>
                        <th class="px-6 py-4 text-center font-medium">Status</th>
                        <th class="px-6 py-4 text-right font-medium">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse ($plans as $plan)
                        <tr class="transition hover:bg-white/5">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <span class="grid h-9 w-9 place-items-center rounded-xl bg-gradient-to-br {{ $plan->gradient ?? 'from-brand to-violet' }} text-base ring-1 ring-white/10">{{ $plan->icon }}</span>
                                    <div>
                                        <p class="font-semibold">{{ $plan->name }} @if($plan->is_featured)<span class="ml-1 text-xs text-brand-bright">★</span>@endif</p>
                                        <p class="text-xs text-white/45">{{ $plan->tagline }}</p>
                                    </div>
                                </div>
                            </td>
                            <td data-label="ROI" class="px-6 py-4 text-right font-semibold tabular-nums text-emerald">{{ rtrim(rtrim(number_format((float) $plan->roi_percent, 2), '0'), '.') }}%</td>
                            <td data-label="Range" class="px-6 py-4 text-right tabular-nums text-white/70">${{ number_format((float) $plan->min_amount) }}–{{ number_format((float) $plan->max_amount) }}</td>
                            <td data-label="Term" class="px-6 py-4 text-right tabular-nums text-white/70">{{ $plan->duration_days }}d</td>
                            <td data-label="Investors" class="px-6 py-4 text-right tabular-nums text-white/70">{{ $plan->investments_count }}</td>
                            <td data-label="Status" class="px-6 py-4 text-center">
                                <span class="rounded-full px-2.5 py-1 text-xs font-semibold {{ $plan->is_active ? 'bg-emerald/15 text-emerald' : 'bg-white/10 text-white/50' }}">{{ $plan->is_active ? 'Active' : 'Hidden' }}</span>
                            </td>
                            <td data-label="" class="px-6 py-4 text-right">
                                <div class="inline-flex items-center gap-3">
                                    <a href="{{ route('admin.plans.edit', $plan) }}" class="text-sm font-semibold text-brand-bright hover:underline">Edit</a>
                                    <form action="{{ route('admin.plans.destroy', $plan) }}" method="post" onsubmit="return confirm('Delete this plan?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-sm font-semibold text-rose-400 hover:underline">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="px-6 py-10 text-center text-white/45">No plans yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">{{ $plans->links() }}</div>

</x-admin-layout>
