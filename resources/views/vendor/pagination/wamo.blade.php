@if ($paginator->hasPages())
    <nav class="flex items-center justify-between gap-2" role="navigation" aria-label="Pagination">
        {{-- Previous --}}
        @if ($paginator->onFirstPage())
            <span class="cursor-not-allowed rounded-xl glass px-4 py-2 text-sm font-medium text-white/30">Previous</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="rounded-xl glass px-4 py-2 text-sm font-medium text-white/80 transition hover:bg-white/10">Previous</a>
        @endif

        {{-- Page numbers (hidden on very small screens) --}}
        <div class="hidden items-center gap-1 sm:flex">
            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="px-2 text-sm text-white/40">{{ $element }}</span>
                @endif
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="grid h-9 min-w-9 place-items-center rounded-xl bg-gradient-to-br from-brand to-violet px-2 text-sm font-bold text-white">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="grid h-9 min-w-9 place-items-center rounded-xl glass px-2 text-sm font-medium text-white/70 transition hover:bg-white/10">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </div>

        {{-- Mobile page indicator --}}
        <span class="text-sm text-white/45 sm:hidden">Page {{ $paginator->currentPage() }} of {{ $paginator->lastPage() }}</span>

        {{-- Next --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="rounded-xl glass px-4 py-2 text-sm font-medium text-white/80 transition hover:bg-white/10">Next</a>
        @else
            <span class="cursor-not-allowed rounded-xl glass px-4 py-2 text-sm font-medium text-white/30">Next</span>
        @endif
    </nav>
@endif
