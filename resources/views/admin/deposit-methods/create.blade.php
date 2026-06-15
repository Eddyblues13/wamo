<x-admin-layout title="New deposit method">

    <a href="{{ route('admin.deposit-methods.index') }}" class="text-sm text-white/50 transition hover:text-white">← Back to methods</a>

    <form action="{{ route('admin.deposit-methods.store') }}" method="post" class="mt-4 max-w-3xl rounded-3xl glass p-7">
        @csrf
        <h2 class="mb-6 text-xl font-bold">Create deposit method</h2>
        @include('admin.deposit-methods._form')
        <div class="mt-6 flex gap-3">
            <button type="submit" class="btn-glow rounded-2xl px-6 py-3 text-sm font-bold text-white">Create method</button>
            <a href="{{ route('admin.deposit-methods.index') }}" class="rounded-2xl glass px-6 py-3 text-sm font-semibold text-white/80 transition hover:bg-white/10">Cancel</a>
        </div>
    </form>

</x-admin-layout>
