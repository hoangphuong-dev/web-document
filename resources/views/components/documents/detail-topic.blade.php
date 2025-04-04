@if (count($docMetaData->ai_topic))
    <div class="container mb-8">
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <!-- Header -->
            <div class="px-5 py-4 bg-blue-50 border-b border-blue-100 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600 mr-2" viewBox="0 0 20 20"
                    fill="#FA8072">
                    <path d="M2 5a2 2 0 012-2h7a2 2 0 012 2v4a2 2 0 01-2 2H9l-3 3v-3H4a2 2 0 01-2-2V5z" />
                    <path
                        d="M15 7v2a4 4 0 01-4 4H9.828l-1.766 1.767c.28.149.599.233.938.233h2l3 3v-3h2a2 2 0 002-2V9a2 2 0 00-2-2h-1z" />
                </svg>
                <p class="font-bold text-lg text-gray-800">Chủ đề</p>
            </div>

            <!-- Topics Grid -->
            <div class="p-5">
                <div class="grid grid-cols-1 gap-3">
                    @forelse ($docMetaData->ai_topic as $topic)
                        <a rel="nofollow" target="_blank" href="{{ URLGenerate::urlTopic($topic->id, $topic->name) }}"
                            class="group">
                            <div
                                class="border border-gray-200 rounded-lg p-3 text-center bg-white hover:bg-blue-600 
                                transition-colors duration-200 group-hover:shadow-md">
                                <span
                                    class="font-medium text-gray-800 group-hover:text-white">{{ $topic->name }}</span>
                            </div>
                        </a>
                    @empty
                        <div class="col-span-full text-center p-4 text-gray-500">
                            Chưa có chủ đề nào được gán cho tài liệu này
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endif
