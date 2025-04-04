<div x-data="paginate" class="my-4 w-full">
    @php $page = request()->page > 0 ? request()->page : 1; @endphp
    <nav role="navigation" aria-label="Pagination Navigation" class="flex justify-center space-x-2">
        @if ($page < 2)
            <span class="p-2 bg-[#ddd] border border-transparent cursor-not-allowed inline-flex rounded text-gray-500">
                @svg('arrow-left', 'h-5 w-5')
            </span>
        @else
            <a rel="prev" x-on:click="paginate('{{ $page ?? 1 }}', 'previousPage')"
                class="p-2 bg-[#ddd] border border-transparent hover:border-primary hover:text-primary inline-flex rounded cursor-pointer">
                @svg('arrow-left', 'h-5 w-5')
            </a>
        @endif
        <span class="inline-flex select-none rounded border border-transparent px-4 py-2 text-sm text-white bg-primary">
            {{ $page ?? 1 }}
        </span>
        <a rel="next" x-on:click="paginate('{{ $page ?? 1 }}', 'nextPage')"
            class="p-2 bg-[#ddd] border border-transparent hover:border-primary hover:text-primary inline-flex rounded cursor-pointer">
            @svg('arrow-right', 'h-5 w-5')
        </a>
    </nav>

    @push('scripts')
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('paginate', () => ({
                    paginate(page, type) {
                        const urlParams = new URLSearchParams(window.location.search);
                        page = Number(page);

                        if (page < 1 || page > 50) {
                            return;
                        }

                        if (type == "nextPage") {
                            page += 1;
                        }

                        if (type == "previousPage") {
                            page -= 1;
                        }
                        urlParams.set('page', page);
                        window.location.search = urlParams;
                    }
                }))
            })
        </script>
    @endpush

</div>
