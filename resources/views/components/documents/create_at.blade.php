<div class="inline-flex items-center px-2 py-1 bg-gray-100 rounded-md text-gray-700 relative group cursor-help mt-3">
    @svg('clock', 'h-3.5 w-3.5 text-gray-500 mr-1.5')
    <span class="text-xs font-medium">{{ \Carbon\Carbon::parse($document?->created_at)->format('d/m/Y') }}</span>
    <!-- Tooltip -->
    <div
        class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-3 py-2 bg-gray-800 text-white text-xs rounded-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 w-36 text-center shadow-lg z-10">
        <div class="absolute bottom-0 left-1/2 transform -translate-x-1/2 translate-y-1/2 rotate-45 w-2 h-2 bg-gray-800">
        </div>
        <span>Ngày đăng</span>
    </div>
</div>
