@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between pt-6 font-mono text-xs">
        
        {{-- Summary --}}
        <div class="text-gray-500">
            Menampilkan <span class="font-bold text-void">{{ $paginator->firstItem() }}</span> - <span class="font-bold text-void">{{ $paginator->lastItem() }}</span> dari <span class="font-bold text-void">{{ $paginator->total() }}</span> data
        </div>

        {{-- Page Buttons --}}
        <div class="flex items-center gap-1.5">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <span class="px-3.5 py-2 rounded-xl bg-gray-50 text-gray-300 border border-black/5 cursor-not-allowed">
                    <i class="bi bi-chevron-left"></i>
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="px-3.5 py-2 rounded-xl bg-white hover:bg-void hover:text-white text-void border border-black/10 shadow-2xs transition">
                    <i class="bi bi-chevron-left"></i>
                </a>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <span class="px-3 py-2 text-gray-400">{{ $element }}</span>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="w-9 h-9 rounded-xl bg-void text-white font-bold flex items-center justify-center border border-black">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}" class="w-9 h-9 rounded-xl bg-white hover:bg-gray-100 text-gray-700 font-bold flex items-center justify-center border border-black/10 transition">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="px-3.5 py-2 rounded-xl bg-white hover:bg-void hover:text-white text-void border border-black/10 shadow-2xs transition">
                    <i class="bi bi-chevron-right"></i>
                </a>
            @else
                <span class="px-3.5 py-2 rounded-xl bg-gray-50 text-gray-300 border border-black/5 cursor-not-allowed">
                    <i class="bi bi-chevron-right"></i>
                </span>
            @endif
        </div>
    </nav>
@endif
