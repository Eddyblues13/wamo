<x-admin-layout title="Deposit methods">

    <div class="mb-6 flex items-center justify-between">
        <p class="text-white/55">Manage the wallet addresses and bank accounts users deposit to.</p>
        <a href="{{ route('admin.deposit-methods.create') }}" class="btn-glow rounded-2xl px-5 py-2.5 text-sm font-bold text-white">+ New method</a>
    </div>

    <div class="overflow-hidden rounded-3xl glass">
        <div class="overflow-x-auto">
            <table class="table-cards w-full text-left text-sm">
                <thead class="border-b border-white/10 text-xs uppercase tracking-wider text-white/40">
                    <tr>
                        <th class="px-6 py-4 font-medium">Method</th>
                        <th class="px-6 py-4 font-medium">Type</th>
                        <th class="px-6 py-4 font-medium">Address / Account</th>
                        <th class="px-6 py-4 text-right font-medium">Min</th>
                        <th class="px-6 py-4 text-center font-medium">Status</th>
                        <th class="px-6 py-4 text-right font-medium">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse ($methods as $m)
                        <tr class="transition hover:bg-white/5">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <span class="text-xl">{{ $m->icon }}</span>
                                    <div>
                                        <p class="font-semibold">{{ $m->name }}</p>
                                        <p class="text-xs text-white/45">{{ $m->code }} {{ $m->network ? '· '.$m->network : '' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td data-label="Type" class="px-6 py-4 capitalize text-white/70">{{ $m->type }}</td>
                            <td data-label="Address / Account" class="px-6 py-4">
                                <code class="break-all text-xs text-white/70">{{ $m->isCrypto() ? $m->address : ($m->bank_name.' · '.$m->account_number) }}</code>
                            </td>
                            <td data-label="Min" class="px-6 py-4 text-right tabular-nums text-white/70">${{ number_format((float) $m->min_amount) }}</td>
                            <td data-label="Status" class="px-6 py-4 text-center">
                                <span class="rounded-full px-2.5 py-1 text-xs font-semibold {{ $m->is_active ? 'bg-emerald/15 text-emerald' : 'bg-white/10 text-white/50' }}">{{ $m->is_active ? 'Active' : 'Hidden' }}</span>
                            </td>
                            <td data-label="" class="px-6 py-4 text-right">
                                <div class="inline-flex items-center gap-3">
                                    <a href="{{ route('admin.deposit-methods.edit', $m) }}" class="text-sm font-semibold text-brand-bright hover:underline">Edit</a>
                                    <form action="{{ route('admin.deposit-methods.destroy', $m) }}" method="post" onsubmit="return confirm('Delete this method?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-sm font-semibold text-rose-400 hover:underline">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-6 py-10 text-center text-white/45">No deposit methods yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">{{ $methods->links() }}</div>

</x-admin-layout>
