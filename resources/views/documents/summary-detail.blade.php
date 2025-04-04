<div class="container mx-auto my-6 bg-white rounded-lg shadow-md transition-all duration-300 hover:shadow-lg">
    <div class="p-4 md:p-6 lg:p-8">
        <!-- Header with improved typography and spacing -->
        <p class="text-xl md:text-2xl lg:text-3xl font-bold text-gray-800 mb-4 pb-2 border-b border-gray-200">
            Tóm tắt
        </p>

        <!-- Loading State with improved animation and visual feedback -->
        @empty($summary)
            <div class="flex flex-col items-center justify-center py-12 space-y-4 bg-gray-50 rounded-lg">
                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-500"></div>
                <p class="text-gray-600 font-medium">Đang tải dữ liệu...</p>
                <p class="text-sm text-gray-500">Vui lòng đợi trong giây lát</p>
            </div>
        @else
            <div class="relative">
                <div class="absolute right-3 top-3 flex space-x-2 z-10">
                    <button class="p-2 rounded-full bg-gray-100 hover:bg-gray-200 transition-colors duration-200"
                        title="Mở rộng">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-600" fill="none"
                            viewBox="0 0 24 24" stroke="#FA8072">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 1v4m0 0h-4m4 0l-5-5" />
                        </svg>
                    </button>
                    <button class="p-2 rounded-full bg-gray-100 hover:bg-gray-200 transition-colors duration-200"
                        title="In">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-600" fill="none"
                            viewBox="0 0 24 24" stroke="#FA8072">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                        </svg>
                    </button>
                </div>

                <!-- Article content with improved styling -->
                <article
                    class="p-4 md:p-6 border border-gray-200 rounded-lg bg-gray-50 hover:bg-white transition-colors duration-300 overflow-auto h-[40vh] custom-scrollbar">
                    <div class="space-y-4 text-sm md:text-base leading-relaxed text-gray-700">
                        {!! $summary !!}
                    </div>
                </article>
            </div>

            <!-- Additional features for better UX -->
            <div
                class="my-4 flex flex-col md:flex-row md:justify-between items-start md:items-center space-y-6 md:space-y-0">
                <!-- Tags/Categories -->
                <div class="flex flex-wrap gap-2 my-2">
                    @forelse ($docMetaData->ai_tag as $tag)
                        <a rel="nofollow" href="{{ URLGenerate::urlTag($tag->id, $tag->name) }}"
                            class="px-4 py-2 text-xs rounded-full bg-green-100 text-green-800 hover:bg-blue-100 hover:text-blue-800">
                            <span>#</span>{{ $tag->name }}
                        </a>
                    @empty
                        <span class="px-3 py-1 text-xs rounded-full bg-blue-100 text-blue-800">Chưa có thẻ</span>
                    @endforelse
                </div>

                <!-- Actions -->
                <div class="flex space-x-3 my-4 md:my-0">
                    <button class="flex items-center space-x-1 text-sm text-gray-600 hover:text-blue-600 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="#FA8072">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                        </svg>
                        <span>Chia sẻ</span>
                    </button>
                    <button class="flex items-center space-x-1 text-sm text-gray-600 hover:text-blue-600 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="#FA8072">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        <span>Tải xuống</span>
                    </button>
                </div>
            </div>
        @endempty

    </div>
</div>

<style>
    .custom-scrollbar {
        scrollbar-width: thin;
        scrollbar-color: rgba(156, 163, 175, 0.5) transparent;
    }

    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }

    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
        background-color: rgba(156, 163, 175, 0.5);
        border-radius: 20px;
    }

    @media (max-width: 768px) {
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }
    }
</style>
