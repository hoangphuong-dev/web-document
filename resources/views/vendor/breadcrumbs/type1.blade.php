@unless ($breadcrumbs->isEmpty())
    <nav aria-label="Breadcrumb" class="py-3">
        <ol class="list-none flex flex-wrap items-center text-sm" itemscope itemtype="https://schema.org/BreadcrumbList">
            @foreach ($breadcrumbs as $breadcrumb)
                @if (!$loop->first)
                    <li aria-hidden="true" class="mx-2 text-gray-400">
                        <svg viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round"
                            stroke-linejoin="round" class="h-3.5 w-3.5 hidden md:block">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                        <span class="md:hidden">/</span>
                    </li>
                @endif
                <li itemscope itemprop="itemListElement" itemtype="https://schema.org/ListItem"
                    class="flex items-center @if($loop->last) font-medium text-gray-700 @else text-gray-500 hover:text-blue-600 transition-colors duration-200 @endif">
                    @if (isset($breadcrumb->isHome) && $breadcrumb->isHome)
                        <span class="inline-flex items-center justify-center">
                            @svg('home', 'h-4 w-4 mr-1')
                        </span>
                    @endif
                    @if($loop->last)
                        <span itemprop="name" class="truncate max-w-xs">{{ $breadcrumb->title }}</span>
                    @else
                        <a itemprop="item" href="{{ $breadcrumb->url }}" class="hover:underline">
                            <span itemprop="name">{{ $breadcrumb->title }}</span>
                        </a>
                    @endif
                    <meta itemprop="position" content="{{ $loop->index + 1 }}">
                </li>
            @endforeach
        </ol>
    </nav>
@endunless