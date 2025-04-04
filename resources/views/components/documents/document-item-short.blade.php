<div class="mt-4 space-y-3">
    @forelse ($documents as $key => $document)
        <div
            class="p-2 sm:p-3 rounded-lg hover:bg-gray-50 transition-colors border border-transparent hover:border-gray-200">
            <div class="min-w-0 overflow-hidden">
                <a href="{{ URLGenerate::urlDocumentDetail($document) }}" class="block">
                    <p
                        class="text-sm sm:text-base text-gray-800 font-medium line-clamp-2 hover:text-blue-600 transition-colors">
                        {{ $document->title }}
                    </p>
                </a>
                <div class="mt-1 sm:mt-2 text-xs sm:text-sm">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-blue-50 rounded-md p-1.5 mt-2 mr-3">
                            @svg($document->ext->icon, 'w-3.5 h-3.5 text-blue-600')
                        </div>
                        @include('documents.parameters')
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="flex flex-col items-center justify-center p-4 sm:p-6 bg-gray-50 rounded-lg">
            <div class="flex items-center justify-center mb-2 text-gray-500">
                @svg('spinner', 'h-4 w-4 sm:h-5 sm:w-5 inline mr-2 animate-spin')
                <span class="text-sm">Đang tải dữ liệu...</span>
            </div>
            <p class="text-xs sm:text-sm text-gray-400">Vui lòng đợi trong giây lát</p>
        </div>
    @endforelse
</div>
