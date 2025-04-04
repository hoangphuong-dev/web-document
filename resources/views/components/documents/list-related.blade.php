@include('components.documents.detail-topic')

<div class="bg-white rounded-lg shadow-lg overflow-hidden space-y-2">
    <div class="px-5 py-4 bg-blue-50 border-b border-blue-100">
        <p class="font-bold text-lg text-gray-800 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-600" viewBox="0 0 20 20"
                fill="#FA8072">
                <path
                    d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z" />
            </svg>
            TÀI LIỆU LIÊN QUAN
        </p>
    </div>

    <div class="p-4">
        <x-documents.document-item-short :documents="$documentRelated" />
    </div>

    <div class="px-4 py-3 bg-gray-50 border-t border-gray-100">
        <a href="#" class="text-primary hover:text-blue-800 text-sm font-medium flex items-center justify-center">
            <span>Xem tất cả</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24"
                stroke="#FA8072">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
            </svg>
        </a>
    </div>
</div>
