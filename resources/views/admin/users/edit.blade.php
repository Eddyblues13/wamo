<x-admin-layout title="Edit user">

    <a href="{{ route('admin.users.show', $user) }}" class="text-sm text-white/50 transition hover:text-white">← Back to user</a>

    <div class="mt-4 max-w-lg rounded-3xl glass p-7">
        <h2 class="text-xl font-bold">Edit {{ $user->name }}</h2>

        <form action="{{ route('admin.users.update', $user) }}" method="post" class="mt-6 space-y-4">
            @csrf @method('PUT')
            <div>
                <label for="name" class="mb-1.5 block text-xs font-medium text-white/50">Name</label>
                <input id="name" name="name" type="text" required value="{{ old('name', $user->name) }}" class="w-full rounded-2xl bg-white/5 px-4 py-3 text-sm text-white outline-none ring-1 ring-white/10 focus:ring-brand-bright">
                @error('name')<p class="mt-1.5 text-xs text-rose-400">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="email" class="mb-1.5 block text-xs font-medium text-white/50">Email</label>
                <input id="email" name="email" type="email" required value="{{ old('email', $user->email) }}" class="w-full rounded-2xl bg-white/5 px-4 py-3 text-sm text-white outline-none ring-1 ring-white/10 focus:ring-brand-bright">
                @error('email')<p class="mt-1.5 text-xs text-rose-400">{{ $message }}</p>@enderror
            </div>
            <label class="flex items-center gap-2 text-sm text-white/70">
                <input type="checkbox" name="verified" value="1" @checked($user->email_verified_at) class="h-4 w-4 rounded border-white/20 bg-white/5 accent-brand">
                Email verified
            </label>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="btn-glow rounded-2xl px-6 py-3 text-sm font-bold text-white">Save changes</button>
                <a href="{{ route('admin.users.show', $user) }}" class="rounded-2xl glass px-6 py-3 text-sm font-semibold text-white/80 transition hover:bg-white/10">Cancel</a>
            </div>
        </form>
    </div>

</x-admin-layout>
