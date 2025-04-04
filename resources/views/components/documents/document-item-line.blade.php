<div class="container mx-auto px-3 md:px-4 lg:px-6">
    @forelse ($documents as $document)
        @php
            $docMeta = $document->metaData;
            $showHeading = $docMeta?->ai_heading
                ? KeywordLibrary::searchKeyword(request()->keyword, $docMeta?->ai_heading)
                : '';
            $urlImage = $document->urlThumbnail();
        @endphp
        <div class="bg-white w-full flex flex-col md:flex-row border border-solid border-slate-200 hover:shadow-lg transition-shadow duration-300 mb-4 p-3 md:p-4 rounded-lg overflow-hidden">
            <!-- Document Thumbnail Section -->
            <div class="relative flex justify-center md:justify-start mb-4 md:mb-0">
                <!-- Document Type Icon Badge -->
                <div class="absolute top-2 right-2 md:left-2 md:right-auto z-10 bg-white/90 backdrop-blur-sm rounded-full p-1 shadow-sm">
                    @svg($document->ext->icon, 'w-5 h-5')
                </div>
                
                <!-- Document Thumbnail -->
                <a href="{{ URLGenerate::urlDocumentDetail($document) }}" class="block overflow-hidden rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200 flex-shrink-0">
                    <img 
                        x-intersect.margin.150.once="$el.src = '{{ $urlImage }}'" 
                        height="200" 
                        width="150"
                        loading="lazy" 
                        src="{{ $urlImage }}" 
                        alt="{{ $document->title }}"
                        class="max-w-full h-auto object-cover transform hover:scale-105 transition-transform duration-300"
                    >
                </a>
            </div>

            <!-- Document Content Section -->
            <div class="flex-1 md:pl-5 flex flex-col justify-between">
                <div class="flex flex-col gap-3">
                    <!-- Document Title -->
                    <div>
                        <a href="{{ URLGenerate::urlDocumentDetail($document) }}"
                           class="font-bold text-gray-800 hover:text-primary transition-colors duration-200 text-base lg:text-lg line-clamp-2 md:line-clamp-none">
                            {!! KeywordLibrary::searchKeyword(request()->keyword, $document->title) !!}
                        </a>
                    </div>
                    
                    <!-- Document Heading (if available) -->
                    @if($showHeading)
                        <p class="text-xs text-gray-600 bg-gray-50 p-2 rounded-md">
                            {!! $showHeading !!}
                        </p>
                    @endif

                    <!-- Document Description (if not hidden) -->
                    @unless ($hiddenDesc)
                        <p class="text-sm md:text-base text-gray-700 line-clamp-3">{{ $docMeta?->ai_description }}</p>
                    @endunless

                    <!-- Document Metadata -->
                    <div class="mt-2 space-y-3">
                        <!-- Category -->
                        <div class="flex flex-col md:flex-row md:items-center text-sm">
                            <span class="font-semibold text-gray-700 md:mr-2 mb-1 md:mb-0">Danh mục:</span>
                            <div class="text-gray-600">
                                {{ Breadcrumbs::render('document-category', $document->breadcrumb, false) }}
                            </div>
                        </div>

                        <!-- Additional document parameters -->
                        <div class="flex flex-wrap gap-y-2 gap-x-4 text-sm">
                            @include('components.documents.year_publish')
                            @include('documents.parameters')
                        </div>
                    </div>
                </div>
                
                <!-- Action buttons -->
                <div class="flex justify-end mt-4 md:mt-2">
                    <a href="{{ URLGenerate::urlDocumentDetail($document) }}" 
                       class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-primary border border-primary rounded-md hover:bg-primary hover:text-white transition-colors duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Xem chi tiết
                    </a>
                </div>
            </div>
        </div>
    @empty
        <!-- Empty state with improved styling -->
        <div class="flex flex-col items-center justify-center py-12 px-4 bg-white rounded-lg border border-dashed border-gray-300 my-6 w-full">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
            </svg>
            <div class="text-center">
                <p class="mt-2 text-base font-medium text-gray-900">Không tìm thấy kết quả</p>
                <p class="mt-1 text-sm text-gray-500">Không tìm thấy kết quả cho từ khóa đã tìm kiếm.</p>
            </div>
            <div class="mt-6 flex text-sm">
                <a href="javascript:history.back()" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                    <svg class="mr-2 -ml-1 w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Quay lại
                </a>
            </div>
        </div>
    @endforelse
</div>