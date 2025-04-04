@if ($year = $document->cover_data?->implementationYear)
    <div class="flex items-center relative group cursor-help">
        @svg('calendar', 'inline w-5 h-5 mr-1 text-gray-600')
        <p class="mt-[2px] font-bold text-gray-800">{{ $year }}</p>
        <!-- Tooltip -->
        <div class="absolute bottom-full left-0 mb-2 px-3 py-2 bg-gray-800 text-white text-xs rounded-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 w-44 text-center shadow-lg z-10">
            <div class="absolute bottom-0 left-6 transform translate-y-1/2 rotate-45 w-2 h-2 bg-gray-800"></div>
            <span>Năm xuất bản</span>
            <span class="block mt-1 text-gray-300 text-xs">(Thời gian tài liệu được phát hành)</span>
        </div>
    </div>
@endif