@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="my-8 flex items-center justify-center">
        <div class="flex flex-1 justify-center sm:hidden">
            @if ($paginator->onFirstPage())
                <span
                    class="p-2 bg-gray-light border border-transparent cursor-not-allowed inline-flex rounded text-gray-darker">
                    @svg('arrow-left', 'h-5 w-5 inline')
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}"
                    class="p-2 bg-gray-light border border-transparent hover:border-primary hover:text-primary inline-flex rounded">
                    @svg('arrow-left', 'h-5 w-5 inline')
                </a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}"
                    class="p-2 bg-gray-light border border-transparent hover:border-primary hover:text-primary inline-flex rounded">
                    @svg('arrow-right', 'h-5 w-5 inline')
                </a>
            @else
                <span
                    class="p-2 bg-gray-light border border-transparent cursor-not-allowed inline-flex rounded text-gray-darker">
                    @svg('arrow-right', 'h-5 w-5 inline')
                </span>
            @endif
        </div>

        <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-center">
            <span class="inline-flex space-x-2">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <span aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
                        <span
                            class="p-2 bg-gray-light border border-transparent cursor-not-allowed inline-flex rounded text-gray-darker"
                            aria-hidden="true">
                            @svg('arrow-left', 'h-5 w-5 inline')
                        </span>
                    </span>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
                        class="p-2 bg-gray-light border border-transparent hover:border-primary hover:text-primary inline-flex rounded"
                        aria-label="{{ __('pagination.previous') }}">
                        @svg('arrow-left', 'h-5 w-5 inline')
                    </a>
                @endif
                {{-- Pagination Elements --}}
                @foreach ($elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <span aria-disabled="true">
                            <span class="inline-flex px-4 py-2">{{ $element }}</span>
                        </span>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <span aria-current="page">
                                    <span
                                        class="inline-flex select-none rounded border border-transparent px-4 py-2 text-sm text-white bg-primary">{{ $page }}</span>
                                </span>
                            @else
                                <a href="{{ $url }}"
                                    class="bg-gray-light border border-transparent hover:text-primary hover:border-primary inline-flex px-4 py-2 rounded select-none text-sm"
                                    aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next"
                        class="p-2 bg-gray-light border border-transparent hover:border-primary hover:text-primary inline-flex rounded"
                        aria-label="{{ __('pagination.next') }}">
                        @svg('arrow-right', 'h-5 w-5 inline')
                    </a>
                @else
                    <span aria-disabled="true" aria-label="{{ __('pagination.next') }}">
                        <span
                            class="p-2 bg-gray-light border border-transparent cursor-not-allowed inline-flex rounded text-gray-darker"
                            aria-hidden="true">
                            @svg('arrow-right', 'h-5 w-5 inline')
                        </span>
                    </span>
                @endif
            </span>
        </div>
    </nav>
@endif
