@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between py-4 px-6 bg-slate-50/80 border-t border-slate-100/80 rounded-b-3xl">
        {{-- Mobile pagination --}}
        <div class="flex justify-between flex-1 sm:hidden">
            @if ($paginator->onFirstPage())
                <span class="relative inline-flex items-center px-4 py-2 text-xs font-bold text-slate-400 bg-white border border-slate-200 rounded-xl cursor-default shadow-2xs">
                    Sebelumnya
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 text-xs font-bold text-slate-700 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition shadow-2xs active:scale-95">
                    Sebelumnya
                </a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="relative inline-flex items-center px-4 py-2 ml-3 text-xs font-bold text-slate-700 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition shadow-2xs active:scale-95">
                    Selanjutnya
                </a>
            @else
                <span class="relative inline-flex items-center px-4 py-2 ml-3 text-xs font-bold text-slate-400 bg-white border border-slate-200 rounded-xl cursor-default shadow-2xs">
                    Selanjutnya
                </span>
            @endif
        </div>

        {{-- Desktop pagination --}}
        <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between gap-4">
            <div>
                <p class="text-xs font-bold text-slate-500">
                    Menampilkan
                    <span class="font-black text-slate-800">{{ $paginator->firstItem() }}</span>
                    sampai
                    <span class="font-black text-slate-800">{{ $paginator->lastItem() }}</span>
                    dari
                    <span class="font-black text-slate-800">{{ $paginator->total() }}</span>
                    data
                </p>
            </div>

            <div>
                <span class="relative z-0 inline-flex shadow-2xs rounded-2xl gap-1 bg-slate-200/60 p-1 border border-slate-200/60">
                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <span aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
                            <span class="relative inline-flex items-center justify-center w-8 h-8 text-xs font-bold text-slate-300 bg-white/40 rounded-xl cursor-default">
                                <i class="bi bi-chevron-left"></i>
                            </span>
                        </span>
                    @else
                        <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="relative inline-flex items-center justify-center w-8 h-8 text-xs font-bold text-slate-700 bg-white rounded-xl hover:bg-blue-600 hover:text-white transition shadow-2xs active:scale-95" aria-label="{{ __('pagination.previous') }}">
                            <i class="bi bi-chevron-left"></i>
                        </a>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <span aria-disabled="true">
                                <span class="relative inline-flex items-center justify-center w-8 h-8 text-xs font-black text-slate-400">
                                    {{ $element }}
                                </span>
                            </span>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span aria-current="page">
                                        <span class="relative inline-flex items-center justify-center w-8 h-8 text-xs font-black text-white bg-gradient-to-br from-blue-600 to-indigo-600 rounded-xl shadow-md shadow-blue-500/25">
                                            {{ $page }}
                                        </span>
                                    </span>
                                @else
                                    <a href="{{ $url }}" class="relative inline-flex items-center justify-center w-8 h-8 text-xs font-bold text-slate-700 bg-white rounded-xl hover:bg-slate-100 hover:text-blue-600 transition shadow-2xs active:scale-95">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="relative inline-flex items-center justify-center w-8 h-8 text-xs font-bold text-slate-700 bg-white rounded-xl hover:bg-blue-600 hover:text-white transition shadow-2xs active:scale-95" aria-label="{{ __('pagination.next') }}">
                            <i class="bi bi-chevron-right"></i>
                        </a>
                    @else
                        <span aria-disabled="true" aria-label="{{ __('pagination.next') }}">
                            <span class="relative inline-flex items-center justify-center w-8 h-8 text-xs font-bold text-slate-300 bg-white/40 rounded-xl cursor-default">
                                <i class="bi bi-chevron-right"></i>
                            </span>
                        </span>
                    @endif
                </span>
            </div>
        </div>
    </nav>
@endif
