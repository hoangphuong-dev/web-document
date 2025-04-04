<div class="container mx-auto px-4">
    <!-- Breadcrumbs Section -->
    <div class="mb-6">
        {{ Breadcrumbs::render('document-category', $document->breadcrumb) }}
    </div>
    <!-- Document Header Section -->
    <div class="bg-white rounded-lg shadow-sm p-4 mb-4">
        <div class="flex flex-wrap items-center gap-2">
            <h1 class="text-xl lg:text-3xl font-bold text-gray-800 flex-grow break-words leading-tight">
                {{ $docMetaData->ai_heading ?? $document->title }}
            </h1>
            <p class="inline-flex items-center justify-center bg-gray-100 rounded-full p-2">
                @svg($document->ext->icon, 'w-6 h-6')
            </p>
        </div>
    </div>
    <!-- Document Details Section -->
    <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
        <!-- Left Column - Document Metadata -->
        <div class="md:col-span-8 bg-white rounded-lg shadow-sm p-4 space-y-4">
            <p class="text-lg font-semibold text-gray-700">Thông tin tài liệu</p>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                @if ($organization = $document->cover_data?->organization)
                    <div class="flex flex-col">
                        <div class="flex items-center text-gray-500 mb-1">
                            @svg('school', 'inline w-5 h-5 mr-2') Đơn vị
                        </div>
                        <a href="#" class="text-black-600 hover:text-black-800 font-semibold transition-colors"
                            rel="nofollow">{{ $organization }}</a>
                    </div>
                @endif

                @if ($location = $document->cover_data?->location)
                    <div class="flex flex-col">
                        <div class="flex items-center text-gray-500 mb-1">
                            @svg('school', 'inline w-5 h-5 mr-2') Địa điểm
                        </div>
                        <a href="#" class="text-black-600 hover:text-black-800 font-semibold transition-colors"
                            rel="nofollow">{{ $location }}</a>
                    </div>
                @endif

                @if ($type = $document->cover_data?->type)
                    <div class="flex flex-col">
                        <div class="flex items-center text-gray-500 mb-1">
                            @svg('subject', 'inline w-5 h-5 mr-2') Loại sáng kiến
                        </div>
                        <a href="#" class="text-black-600 hover:text-black-800 font-semibold transition-colors"
                            rel="nofollow">{{ $type }}</a>
                    </div>
                @endif

                @if ($recognitionLevel = $document->cover_data?->recognitionLevel)
                    <div class="flex flex-col">
                        <div class="flex items-center text-gray-500 mb-1">
                            @svg('flag', 'inline w-5 h-5 mr-2') Cấp công nhận
                        </div>
                        <p class="text-black-600 hover:text-black-800 font-semibold transition-colors">
                            {{ $recognitionLevel }}</p>
                    </div>
                @endif
            </div>
            {{-- Chỉ cho hiện một cột với vấn đề / giải pháp --}}
            <div class="grid grid-cols-1 gap-6">
                @if ($problem = $document->cover_data?->problem)
                    <div class="flex flex-col">
                        <div class="flex items-center text-gray-500 mb-1">
                            @svg('flag', 'inline w-5 h-5 mr-2') Vấn đề
                        </div>
                        <p class="text-black-600 hover:text-black-800 font-semibold transition-colors">{{ $problem }}
                        </p>
                    </div>
                @endif
                @if ($solution = $document->cover_data?->solution)
                    <div class="flex flex-col">
                        <div class="flex items-center text-gray-500 mb-1">
                            @svg('flag', 'inline w-5 h-5 mr-2') Giải pháp
                        </div>
                        <p class="text-black-600 hover:text-black-800 font-semibold transition-colors">{{ $solution }}
                        </p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Right Column - Additional Details -->
        <div class="md:col-span-4">
            <div class="bg-white rounded-lg shadow-sm p-4 mb-4">
                <p class="text-lg font-semibold mb-4 text-gray-700">Thông tin đặc trưng</p>
                <div class="flex flex-col space-y-4">
                    <div class="flex justify-between items-center">
                        @include('components.documents.year_publish')
                    </div>
                    <div class="flex justify-between items-center">
                        @include('documents.parameters')
                        @include('components.documents.create_at')
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center justify-between bg-black-50 rounded-lg p-4">
                    <div class="flex items-center">
                        @svg('money', 'h-5 w-5 text-black-600')
                        <span class="ml-3 text-gray-700">Phí lưu trữ</span>
                    </div>
                    <span
                        class="font-bold text-lg text-black-700">{{ Formatter::numberFormatVn($document->money_sale) }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
