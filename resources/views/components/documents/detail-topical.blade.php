@if (!empty($docMetaData->ai_topical))
    <div class="bg-white shadow-lg rounded-lg overflow-hidden my-8 border border-slate-200">
        <!-- Header -->
        <div class="px-5 py-4 bg-blue-50 border-b border-blue-100 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600 mr-2" viewBox="0 0 20 20"
                fill="#FA8072">
                <path fill-rule="evenodd"
                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1V9a1 1 0 00-1-1z"
                    clip-rule="evenodd" />
            </svg>
            <p class="font-bold text-lg text-gray-800">Đề xuất tham khảo</p>
        </div>

        <!-- Content -->
        <div class="px-5 py-4 leading-7 prose max-w-none">
            {!! $docMetaData->ai_topical !!}
        </div>
    </div>
@endif
