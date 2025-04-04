<div class="grid sm:grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
    @forelse ($documents as $document)
        @php
            $title = $isDescription ? ($document?->metaData?->ai_title ?: $document->title) : $document->title;
        @endphp

        <div
            class="bg-white rounded-lg border border-gray-200 hover:shadow-md transition-all duration-300 overflow-hidden flex flex-col sm:flex-row">
            <!-- Thumbnail with icon overlay -->
            <div class="relative flex-shrink-0">
                <a href="{{ URLGenerate::urlDocumentDetail($document) }}" class="block">
                    <img x-intersect.margin.150.once="$el.src = '{{ ImageHelper::getImageDefault('doc') }}'"
                        height="180" width="135" src="{{ ImageHelper::getImageDefault('doc') }}"
                        alt="{{ $title }}" class="object-cover h-full w-full sm:w-32 md:w-36">
                    <div class="absolute top-2 right-2 bg-white bg-opacity-90 rounded-full p-1.5 shadow-sm">
                        @svg($document->ext->icon, 'w-4 h-4 text-blue-600')
                    </div>
                </a>
            </div>

            <!-- Document information -->
            <div class="p-3 sm:p-4 flex flex-col flex-grow">
                <!-- Title -->
                <a href="{{ URLGenerate::urlDocumentDetail($document) }}"
                    class="font-semibold text-gray-900 hover:text-blue-600 transition-colors mb-2 line-clamp-2">
                    {{ $title }}
                </a>

                <!-- Description if available -->
                @if ($isDescription && $document?->metaData?->ai_description)
                    <div class="text-sm text-gray-600 mb-2 line-clamp-2">
                        {{ $document?->metaData?->ai_description }}
                    </div>
                @endif

                <!-- Meta information -->
                <div class="mt-auto space-y-2 text-xs text-gray-500">
                    <div class="flex items-center">
                        <span class="inline-block w-5 h-5 mr-1.5 text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="#FA8072">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </span>
                        {{ Carbon\Carbon::parse($document?->created_at)->format('d/m/Y') }}
                    </div>

                    <div class="flex items-start">
                        <div class="flex-1">
                            {{ Breadcrumbs::render('document-category', $document->breadcrumb, false) }}
                        </div>
                    </div>
                    <div>
                        @include('documents.parameters')
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="flex items-center justify-center col-span-1 sm:col-span-2 py-10">
            <div class="text-center">
                @svg('spinner', 'h-6 w-6 inline-block text-blue-600 animate-spin mr-2')
                <span class="text-gray-600">Đang tải dữ liệu...</span>
            </div>
        </div>
    @endforelse
</div>
