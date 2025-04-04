<div>
    @if ($paginator->hasPages())
        <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-center space-x-2 my-4">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <span
                    class="p-2 bg-gray-light border border-transparent cursor-not-allowed inline-flex rounded text-gray-darker">
                    @svg('arrow-left', 'h-5 w-5 inline')
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="Trang trước"
                    class="p-2 bg-gray-light border border-transparent hover:border-primary hover:text-primary inline-flex rounded">
                    @svg('arrow-left', 'h-5 w-5 inline')
                </a>
            @endif

            <span
                class="inline-flex select-none rounded border border-transparent px-4 py-2 text-sm text-white bg-primary">
                {{ $paginator->currentPage() }}
            </span>

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="Trang tiếp theo"
                    class="p-2 bg-gray-light border border-transparent hover:border-primary hover:text-primary inline-flex rounded">
                    @svg('arrow-right', 'h-5 w-5 inline')
                </a>
            @else
                <span
                    class="p-2 bg-gray-light border border-transparent cursor-not-allowed inline-flex rounded text-gray-darker">
                    @svg('arrow-right', 'h-5 w-5 inline')
                </span>
            @endif
        </nav>
    @endif

</div>
