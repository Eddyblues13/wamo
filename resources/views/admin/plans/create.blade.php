<x-admin-layout title="New plan">

    <a href="{{ route('admin.plans.index') }}" class="text-sm text-white/50 transition hover:text-white">← Back to plans</a>

    <form action="{{ route('admin.plans.store') }}" method="post" class="mt-4 max-w-2xl rounded-3xl glass p-7">
        @csrf
        <h2 class="mb-6 text-xl font-bold">Create investment plan</h2>
        @include('admin.plans._form')
        <div class="mt-6 flex gap-3">
            <button type="submit" class="btn-glow rounded-2xl px-6 py-3 text-sm font-bold text-white">Create plan</button>
            <a href="{{ route('admin.plans.index') }}" class="rounded-2xl glass px-6 py-3 text-sm font-semibold text-white/80 transition hover:bg-white/10">Cancel</a>
        </div>
    </form>

</x-admin-layout>
