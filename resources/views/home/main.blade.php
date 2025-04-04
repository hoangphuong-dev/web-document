@extends('layouts.app')

@section('content')
    <h1 class="hidden">{{ config('app.name') }} - Nền tảng chia sẻ sáng kiến kinh nghiệm chuyên nghiệp hàng đầu Việt Nam</h1>
    <h2 class="hidden">
        Tổng hợp sáng kiến kinh nghiệm chất lượng
    </h2>
    <!-- Main Content -->
    <main class="container mx-auto px-4 py-12">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Tài liệu mới nhất -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition duration-300">
                <div class="bg-gradient-to-r from-blue-500 to-indigo-600 px-6 py-4">
                    <h3 class="text-xl font-bold text-white flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Tài liệu mới nhất
                    </h3>
                </div>
                <div class="p-6">
                    <ul class="space-y-4">
                        @forelse ($latestDoc as $i => $document)
                            <li class="border-b border-gray-100 pb-4 last:border-b-0 last:pb-0">
                                <a href="{{ URLGenerate::urlDocumentDetail($document) }}"
                                    class="flex items-start hover:bg-gray-50 p-2 rounded-lg transition duration-200">
                                    <span
                                        class="flex-shrink-0 w-10 h-10 rounded-lg bg-indigo-100 text-indigo-700 flex items-center justify-center mr-3 font-bold text-sm">
                                        {{ $i + 1 }}
                                    </span>
                                    <div>
                                        <h4 class="font-medium text-gray-900 hover:text-indigo-600 line-clamp-2">
                                            {{ $document->title }}
                                        </h4>
                                        <div class="flex items-center mt-1 text-sm text-gray-500">
                                            <span class="bg-blue-100 text-blue-700 rounded-full px-2 py-0.5 text-xs mr-2">
                                                {{ \Arr::get(\Arr::last($document->breadcrumb), 'name') }}
                                            </span>
                                            <span>{{ \Carbon\Carbon::parse($document?->created_at)->format('d/m/Y') }}</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        @empty
                            <div class="flex items-center justify-center col-span-1 sm:col-span-2 py-10">
                                <div class="text-center">
                                    @svg('spinner', 'h-6 w-6 inline-block text-blue-600 animate-spin mr-2')
                                    <span class="text-gray-600">Đang tải dữ liệu...</span>
                                </div>
                            </div>
                        @endforelse
                    </ul>
                    <a href="#" class="block text-center mt-6 text-indigo-600 hover:text-indigo-800 font-bold">Xem
                        tất cả →</a>
                </div>
            </div>

            <!-- Tài liệu tải nhiều nhất -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition duration-300">
                <div class="bg-gradient-to-r from-blue-500 to-indigo-600 px-6 py-4">
                    <h3 class="text-xl font-bold text-white flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                        </svg>
                        Tài liệu tải nhiều nhất
                    </h3>
                </div>
                <div class="p-6">
                    <ul class="space-y-4">
                        @forelse ($multipleDownloadDoc as $i => $document)
                            <li class="border-b border-gray-100 pb-4 last:border-b-0 last:pb-0">
                                <a href="{{ URLGenerate::urlDocumentDetail($document) }}"
                                    class="flex items-start hover:bg-gray-50 p-2 rounded-lg transition duration-200">
                                    <span
                                        class="flex-shrink-0 w-10 h-10 rounded-lg bg-indigo-100 text-indigo-700 flex items-center justify-center mr-3 font-bold text-sm">
                                        {{ $i + 1 }}
                                    </span>
                                    <div>
                                        <h4 class="font-medium text-gray-900 hover:text-indigo-600 line-clamp-2">
                                            {{ $document->title }}
                                        </h4>
                                        <div class="flex items-center mt-1 text-sm text-gray-500">
                                            <span class="bg-blue-100 text-blue-700 rounded-full px-2 py-0.5 text-xs mr-2">
                                                {{ \Arr::get(\Arr::last($document->breadcrumb), 'name') }}
                                            </span>
                                            <span>{{ \Carbon\Carbon::parse($document?->created_at)->format('d/m/Y') }}</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        @empty
                            <div class="flex items-center justify-center col-span-1 sm:col-span-2 py-10">
                                <div class="text-center">
                                    @svg('spinner', 'h-6 w-6 inline-block text-blue-600 animate-spin mr-2')
                                    <span class="text-gray-600">Đang tải dữ liệu...</span>
                                </div>
                            </div>
                        @endforelse
                    </ul>
                    <a href="#" class="block text-center mt-6 text-indigo-600 hover:text-indigo-800 font-bold">Xem
                        tất cả →</a>
                </div>
            </div>

            <!-- Tài liệu xem nhiều nhất -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition duration-300">
                <div class="bg-gradient-to-r from-blue-500 to-indigo-600 px-6 py-4">
                    <h3 class="text-xl font-bold text-white flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                            </path>
                        </svg>
                        Tài liệu xem nhiều nhất
                    </h3>
                </div>
                <div class="p-6">
                    <ul class="space-y-4">
                        @forelse ($mosViewDoc as $i => $document)
                            <li class="border-b border-gray-100 pb-4 last:border-b-0 last:pb-0">
                                <a href="{{ URLGenerate::urlDocumentDetail($document) }}"
                                    class="flex items-start hover:bg-gray-50 p-2 rounded-lg transition duration-200">
                                    <span
                                        class="flex-shrink-0 w-10 h-10 rounded-lg bg-indigo-100 text-indigo-700 flex items-center justify-center mr-3 font-bold text-sm">
                                        {{ $i + 1 }}
                                    </span>
                                    <div>
                                        <h4 class="font-medium text-gray-900 hover:text-indigo-600 line-clamp-2">
                                            {{ $document->title }}</h4>
                                        <div class="flex items-center mt-1 text-sm text-gray-500">
                                            <span class="bg-blue-100 text-blue-700 rounded-full px-2 py-0.5 text-xs mr-2">
                                                {{ \Arr::get(\Arr::last($document->breadcrumb), 'name') }}
                                            </span>
                                            <span>{{ \Carbon\Carbon::parse($document?->created_at)->format('d/m/Y') }}</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        @empty
                            <div class="flex items-center justify-center col-span-1 sm:col-span-2 py-10">
                                <div class="text-center">
                                    @svg('spinner', 'h-6 w-6 inline-block text-blue-600 animate-spin mr-2')
                                    <span class="text-gray-600">Đang tải dữ liệu...</span>
                                </div>
                            </div>
                        @endforelse
                    </ul>
                    <a href="#" class="block text-center mt-6 text-indigo-600 hover:text-indigo-800 font-bold">Xem
                        tất cả →</a>
                </div>
            </div>
        </div>
    </main>

    <!-- Categories Section -->
    <section class="bg-gray-50 py-12">
        <div class="container mx-auto px-4">
            <h2 class="text-2xl font-bold text-center mb-10">Danh mục tài liệu</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                <a href="https://khosangkien.com/danh-muc/sang-kien-tieu-hoc.c17"
                    class="flex flex-col items-center p-6 bg-white rounded-xl shadow-sm hover:shadow-md transition duration-300 text-center">
                    <svg class="w-12 h-12 text-blue-600 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                        </path>
                    </svg>
                    <span class="font-medium">Sáng kiến tiểu học</span>
                    <span class="text-sm text-gray-500 mt-1">2.345 tài liệu</span>
                </a>
                <a href="https://khosangkien.com/danh-muc/phuong-phap-giang-day.c11"
                    class="flex flex-col items-center p-6 bg-white rounded-xl shadow-sm hover:shadow-md transition duration-300 text-center">
                    <svg class="w-12 h-12 text-amber-600 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                    <span class="font-medium">Phương pháp giảng dạy</span>
                    <span class="text-sm text-gray-500 mt-1">1.873 tài liệu</span>
                </a>
                <a href="https://khosangkien.com/danh-muc/sang-kien-mam-non.c16"
                    class="flex flex-col items-center p-6 bg-white rounded-xl shadow-sm hover:shadow-md transition duration-300 text-center">
                    <svg class="w-12 h-12 text-emerald-600 mb-3" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    <span class="font-medium">Sáng kiến mầm non</span>
                    <span class="text-sm text-gray-500 mt-1">3.142 tài liệu</span>
                </a>
                <a href="https://khosangkien.com/danh-muc/cong-nghe-trong-giao-duc.c15"
                    class="flex flex-col items-center p-6 bg-white rounded-xl shadow-sm hover:shadow-md transition duration-300 text-center">
                    <svg class="w-12 h-12 text-purple-600 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z">
                        </path>
                    </svg>
                    <span class="font-medium">Công nghệ trong giáo dục</span>
                    <span class="text-sm text-gray-500 mt-1">965 tài liệu</span>
                </a>
                <a href="https://khosangkien.com/danh-muc/he-thong-thong-tin-quan-ly.c64"
                    class="flex flex-col items-center p-6 bg-white rounded-xl shadow-sm hover:shadow-md transition duration-300 text-center">
                    <svg class="w-12 h-12 text-red-600 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                        </path>
                    </svg>
                    <span class="font-medium">Hệ thống thông tin quản lý</span>
                    <span class="text-sm text-gray-500 mt-1">1.256 tài liệu</span>
                </a>
                <a href="https://khosangkien.com/danh-muc/quan-ly-lop-hoc.c12"
                    class="flex flex-col items-center p-6 bg-white rounded-xl shadow-sm hover:shadow-md transition duration-300 text-center">
                    <svg class="w-12 h-12 text-sky-600 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                        </path>
                    </svg>
                    <span class="font-medium">Khác</span>
                    <span class="text-sm text-gray-500 mt-1">2.789 tài liệu</span>
                </a>
            </div>
        </div>
    </section>
@endsection
