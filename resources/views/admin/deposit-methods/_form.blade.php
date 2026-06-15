@php $m = $method; @endphp

<div class="grid gap-4 sm:grid-cols-2">
    <div>
        <label class="mb-1.5 block text-xs font-medium text-white/50">Display name</label>
        <input name="name" type="text" required value="{{ old('name', $m->name) }}" placeholder="USDT (TRC20)" class="w-full rounded-2xl bg-white/5 px-4 py-3 text-sm text-white outline-none ring-1 ring-white/10 focus:ring-brand-bright">
        @error('name')<p class="mt-1.5 text-xs text-rose-400">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="mb-1.5 block text-xs font-medium text-white/50">Type</label>
        <select name="type" class="w-full rounded-2xl bg-white/5 px-4 py-3 text-sm text-white outline-none ring-1 ring-white/10 focus:ring-brand-bright">
            <option value="crypto" @selected(old('type', $m->type) === 'crypto')>Crypto</option>
            <option value="bank" @selected(old('type', $m->type) === 'bank')>Bank</option>
        </select>
    </div>

    <div>
        <label class="mb-1.5 block text-xs font-medium text-white/50">Icon (emoji)</label>
        <input name="icon" type="text" maxlength="8" value="{{ old('icon', $m->icon) }}" placeholder="🟢" class="w-full rounded-2xl bg-white/5 px-4 py-3 text-sm text-white outline-none ring-1 ring-white/10 focus:ring-brand-bright">
    </div>
    <div>
        <label class="mb-1.5 block text-xs font-medium text-white/50">Minimum amount ($)</label>
        <input name="min_amount" type="number" step="0.01" min="0" required value="{{ old('min_amount', $m->min_amount ?? 0) }}" class="w-full rounded-2xl bg-white/5 px-4 py-3 text-sm text-white outline-none ring-1 ring-white/10 focus:ring-brand-bright">
        @error('min_amount')<p class="mt-1.5 text-xs text-rose-400">{{ $message }}</p>@enderror
    </div>

    <div class="rounded-2xl border border-white/10 p-4 sm:col-span-2">
        <p class="mb-3 text-xs font-semibold uppercase tracking-wider text-brand-bright">Crypto details</p>
        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <label class="mb-1.5 block text-xs font-medium text-white/50">Coin code</label>
                <input name="code" type="text" value="{{ old('code', $m->code) }}" placeholder="USDT" class="w-full rounded-2xl bg-white/5 px-4 py-3 text-sm text-white outline-none ring-1 ring-white/10 focus:ring-brand-bright">
            </div>
            <div>
                <label class="mb-1.5 block text-xs font-medium text-white/50">Network</label>
                <input name="network" type="text" value="{{ old('network', $m->network) }}" placeholder="TRC20" class="w-full rounded-2xl bg-white/5 px-4 py-3 text-sm text-white outline-none ring-1 ring-white/10 focus:ring-brand-bright">
            </div>
            <div class="sm:col-span-2">
                <label class="mb-1.5 block text-xs font-medium text-white/50">Wallet address</label>
                <input name="address" type="text" value="{{ old('address', $m->address) }}" placeholder="TXxxxxxxxxxxxxxxxxxxxxxxxxx" class="w-full rounded-2xl bg-white/5 px-4 py-3 text-sm text-white outline-none ring-1 ring-white/10 focus:ring-brand-bright">
            </div>
        </div>
    </div>

    <div class="rounded-2xl border border-white/10 p-4 sm:col-span-2">
        <p class="mb-3 text-xs font-semibold uppercase tracking-wider text-brand-bright">Bank details</p>
        <div class="grid gap-4 sm:grid-cols-3">
            <div>
                <label class="mb-1.5 block text-xs font-medium text-white/50">Bank name</label>
                <input name="bank_name" type="text" value="{{ old('bank_name', $m->bank_name) }}" class="w-full rounded-2xl bg-white/5 px-4 py-3 text-sm text-white outline-none ring-1 ring-white/10 focus:ring-brand-bright">
            </div>
            <div>
                <label class="mb-1.5 block text-xs font-medium text-white/50">Account name</label>
                <input name="account_name" type="text" value="{{ old('account_name', $m->account_name) }}" class="w-full rounded-2xl bg-white/5 px-4 py-3 text-sm text-white outline-none ring-1 ring-white/10 focus:ring-brand-bright">
            </div>
            <div>
                <label class="mb-1.5 block text-xs font-medium text-white/50">Account number</label>
                <input name="account_number" type="text" value="{{ old('account_number', $m->account_number) }}" class="w-full rounded-2xl bg-white/5 px-4 py-3 text-sm text-white outline-none ring-1 ring-white/10 focus:ring-brand-bright">
            </div>
        </div>
    </div>

    <div class="sm:col-span-2">
        <label class="mb-1.5 block text-xs font-medium text-white/50">Instructions to the user</label>
        <textarea name="instructions" rows="2" class="w-full rounded-2xl bg-white/5 px-4 py-3 text-sm text-white outline-none ring-1 ring-white/10 focus:ring-brand-bright">{{ old('instructions', $m->instructions) }}</textarea>
    </div>

    <div>
        <label class="mb-1.5 block text-xs font-medium text-white/50">Sort order</label>
        <input name="sort_order" type="number" min="0" value="{{ old('sort_order', $m->sort_order ?? 0) }}" class="w-full rounded-2xl bg-white/5 px-4 py-3 text-sm text-white outline-none ring-1 ring-white/10 focus:ring-brand-bright">
    </div>
    <label class="flex items-center gap-2 self-end pb-3 text-sm text-white/70">
        <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $m->exists ? $m->is_active : true)) class="h-4 w-4 rounded border-white/20 bg-white/5 accent-brand"> Active
    </label>
</div>
