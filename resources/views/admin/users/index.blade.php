<x-admin-layout title="Users">

    <form method="get" class="mb-6 flex max-w-md items-center gap-2">
        <input type="text" name="search" value="{{ $search }}" placeholder="Search by name or email…" class="w-full rounded-2xl bg-white/5 px-4 py-2.5 text-sm text-white outline-none ring-1 ring-white/10 transition focus:ring-brand-bright">
        <button type="submit" class="rounded-2xl glass px-4 py-2.5 text-sm font-semibold text-white/90 transition hover:bg-white/10">Search</button>
        @if ($search)
            <a href="{{ route('admin.users.index') }}" class="rounded-2xl px-3 py-2.5 text-sm text-white/50 hover:text-white">Clear</a>
        @endif
    </form>

    <div class="overflow-hidden rounded-3xl glass">
        <div class="overflow-x-auto">
            <table class="table-cards w-full text-left text-sm">
                <thead class="border-b border-white/10 text-xs uppercase tracking-wider text-white/40">
                    <tr>
                        <th class="px-6 py-4 font-medium">User</th>
                        <th class="px-6 py-4 font-medium">Status</th>
                        <th class="px-6 py-4 text-right font-medium">Balance</th>
                        <th class="px-6 py-4 text-right font-medium">Investments</th>
                        <th class="px-6 py-4 text-right font-medium">Joined</th>
                        <th class="px-6 py-4 text-right font-medium">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse ($users as $user)
                        <tr class="transition hover:bg-white/5">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <span class="grid h-9 w-9 place-items-center rounded-full bg-gradient-to-br from-brand to-violet text-sm font-bold">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                    <div>
                                        <p class="font-semibold">{{ $user->name }}</p>
                                        <p class="text-xs text-white/45">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td data-label="Status" class="px-6 py-4">
                                @if ($user->email_verified_at)
                                    <span class="rounded-full bg-emerald/15 px-2.5 py-1 text-xs font-semibold text-emerald">Verified</span>
                                @else
                                    <span class="rounded-full bg-amber-400/15 px-2.5 py-1 text-xs font-semibold text-amber-300">Pending</span>
                                @endif
                            </td>
                            <td data-label="Balance" class="px-6 py-4 text-right font-semibold tabular-nums">${{ number_format((float) $user->balance, 2) }}</td>
                            <td data-label="Investments" class="px-6 py-4 text-right tabular-nums text-white/70">{{ $user->investments_count }}</td>
                            <td data-label="Joined" class="px-6 py-4 text-right tabular-nums text-white/50">{{ $user->created_at->format('M j, Y') }}</td>
                            <td data-label="" class="px-6 py-4 text-right">
                                <a href="{{ route('admin.users.show', $user) }}" class="text-sm font-semibold text-brand-bright hover:underline">Manage</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-6 py-10 text-center text-white/45">No users found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">{{ $users->links() }}</div>

</x-admin-layout>
