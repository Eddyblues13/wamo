@php $p = $plan; @endphp

<div class="grid gap-4 sm:grid-cols-2">
    <div class="sm:col-span-2">
        <label class="mb-1.5 block text-xs font-medium text-white/50">Name</label>
        <input name="name" type="text" required value="{{ old('name', $p->name) }}" class="w-full rounded-2xl bg-white/5 px-4 py-3 text-sm text-white outline-none ring-1 ring-white/10 focus:ring-brand-bright">
        @error('name')<p class="mt-1.5 text-xs text-rose-400">{{ $message }}</p>@enderror
    </div>

    <div class="sm:col-span-2">
        <label class="mb-1.5 block text-xs font-medium text-white/50">Tagline</label>
        <input name="tagline" type="text" required value="{{ old('tagline', $p->tagline) }}" class="w-full rounded-2xl bg-white/5 px-4 py-3 text-sm text-white outline-none ring-1 ring-white/10 focus:ring-brand-bright">
        @error('tagline')<p class="mt-1.5 text-xs text-rose-400">{{ $message }}</p>@enderror
    </div>

    <div class="sm:col-span-2">
        <label class="mb-1.5 block text-xs font-medium text-white/50">Description</label>
        <textarea name="description" rows="3" required class="w-full rounded-2xl bg-white/5 px-4 py-3 text-sm text-white outline-none ring-1 ring-white/10 focus:ring-brand-bright">{{ old('description', $p->description) }}</textarea>
        @error('description')<p class="mt-1.5 text-xs text-rose-400">{{ $message }}</p>@enderror
    </div>

    <div>
        <label class="mb-1.5 block text-xs font-medium text-white/50">Icon (emoji)</label>
        <input name="icon" type="text" maxlength="8" value="{{ old('icon', $p->icon) }}" placeholder="💎" class="w-full rounded-2xl bg-white/5 px-4 py-3 text-sm text-white outline-none ring-1 ring-white/10 focus:ring-brand-bright">
    </div>
    <div>
        <label class="mb-1.5 block text-xs font-medium text-white/50">Gradient (Tailwind classes)</label>
        <input name="gradient" type="text" value="{{ old('gradient', $p->gradient) }}" placeholder="from-violet-400/30 to-purple-500/10" class="w-full rounded-2xl bg-white/5 px-4 py-3 text-sm text-white outline-none ring-1 ring-white/10 focus:ring-brand-bright">
    </div>

    <div>
        <label class="mb-1.5 block text-xs font-medium text-white/50">Minimum amount ($)</label>
        <input name="min_amount" type="number" step="0.01" min="0" required value="{{ old('min_amount', $p->min_amount) }}" class="w-full rounded-2xl bg-white/5 px-4 py-3 text-sm text-white outline-none ring-1 ring-white/10 focus:ring-brand-bright">
        @error('min_amount')<p class="mt-1.5 text-xs text-rose-400">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="mb-1.5 block text-xs font-medium text-white/50">Maximum amount ($)</label>
        <input name="max_amount" type="number" step="0.01" min="0" required value="{{ old('max_amount', $p->max_amount) }}" class="w-full rounded-2xl bg-white/5 px-4 py-3 text-sm text-white outline-none ring-1 ring-white/10 focus:ring-brand-bright">
        @error('max_amount')<p class="mt-1.5 text-xs text-rose-400">{{ $message }}</p>@enderror
    </div>

    <div>
        <label class="mb-1.5 block text-xs font-medium text-white/50">ROI (%)</label>
        <input name="roi_percent" type="number" step="0.01" min="0" required value="{{ old('roi_percent', $p->roi_percent) }}" class="w-full rounded-2xl bg-white/5 px-4 py-3 text-sm text-white outline-none ring-1 ring-white/10 focus:ring-brand-bright">
        @error('roi_percent')<p class="mt-1.5 text-xs text-rose-400">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="mb-1.5 block text-xs font-medium text-white/50">Duration (days)</label>
        <input name="duration_days" type="number" min="1" required value="{{ old('duration_days', $p->duration_days) }}" class="w-full rounded-2xl bg-white/5 px-4 py-3 text-sm text-white outline-none ring-1 ring-white/10 focus:ring-brand-bright">
        @error('duration_days')<p class="mt-1.5 text-xs text-rose-400">{{ $message }}</p>@enderror
    </div>

    <div>
        <label class="mb-1.5 block text-xs font-medium text-white/50">Payout interval</label>
        <input name="payout_interval" type="text" required value="{{ old('payout_interval', $p->payout_interval ?? 'At maturity') }}" class="w-full rounded-2xl bg-white/5 px-4 py-3 text-sm text-white outline-none ring-1 ring-white/10 focus:ring-brand-bright">
    </div>
    <div>
        <label class="mb-1.5 block text-xs font-medium text-white/50">Sort order</label>
        <input name="sort_order" type="number" min="0" value="{{ old('sort_order', $p->sort_order ?? 0) }}" class="w-full rounded-2xl bg-white/5 px-4 py-3 text-sm text-white outline-none ring-1 ring-white/10 focus:ring-brand-bright">
    </div>

    <label class="flex items-center gap-2 text-sm text-white/70">
        <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $p->is_featured)) class="h-4 w-4 rounded border-white/20 bg-white/5 accent-brand"> Featured
    </label>
    <label class="flex items-center gap-2 text-sm text-white/70">
        <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $p->exists ? $p->is_active : true)) class="h-4 w-4 rounded border-white/20 bg-white/5 accent-brand"> Active
    </label>
</div>
