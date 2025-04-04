@extends('layouts.app')

@push('scripts')
    <script>
        document.querySelectorAll('div.topical a').forEach(function(link) {
            link.setAttribute('target', '_blank');
        });
    </script>
@endpush

@section('content')
    <x-alert class="justify-center text-xl my-4" />

    @if ($canView)
        {{-- Hiển thị breadcumd và tên tài liệu --}}
        <div class="id-{{ $document->id }} bg-white md:py-6 w-full md:px-4 p-2 md:shadow-lg rounded">
            @include('documents.header-document')
        </div>
        @include('documents.summary-detail')
        <div class="container mx-auto my-6">
            <div class="flex flex-col lg:flex-row lg:gap-8">
                <!-- Sidebar for desktop - Left column -->
                <div class="hidden lg:block lg:w-1/4">
                    @includeWhen(!Agent::isMobile(), 'components.documents.list-related')
                </div>
                
                <!-- Main content - Center/Right area -->
                <div class="w-full lg:w-3/4">
                    <!-- Document preview container -->
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-6">
                        <!-- Document header -->
                        <div class="bg-blue-50 px-5 py-4 border-b border-blue-100">
                            <p class="text-xl font-bold text-gray-800">{{ $document->title }}</p>
                            <div class="flex items-center mt-2">
                                <span class="px-3 py-1 text-xs font-medium bg-blue-100 text-blue-700 rounded-full">
                                    Xem trước
                                </span>
                            </div>
                        </div>

                        <!-- Document viewer -->
                        <div class="bg-gray-50">
                            @php $typePreview = App\Enums\Document\EagerLoadScene::PREVIEW; @endphp
                            <livewire:document.eager-load-document-detail :document="$document" :type='$typePreview' />
                        </div>

                        <!-- Document footer -->
                        <div class="sticky bottom-0 left-0 right-0 z-30">
                            <div class="bg-gradient-to-t from-white via-white to-transparent h-6"></div>
                            <div class="bg-white border-t border-gray-200 shadow-md">
                                <div class="container mx-auto">
                                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4 px-4 py-4 md:py-5">
                                        <!-- Document preview info -->
                                        <div class="md:col-span-9 flex items-center">
                                            <div class="flex-shrink-0 mr-3 hidden sm:block">
                                                <div class="bg-amber-100 rounded-full p-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-600"
                                                        fill="none" viewBox="0 0 24 24" stroke="#FA8072">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                </div>
                                            </div>
                                            <div>
                                                <p class="text-sm text-gray-600 mb-1">Bạn đang xem trước tài liệu:</p>
                                                <p class="font-semibold text-gray-900 text-base">
                                                    {{ $document->title }}
                                                </p>
                                            </div>
                                        </div>

                                        <!-- Download button -->
                                        <div class="md:col-span-3 flex items-center justify-start md:justify-end">
                                            <a rel="nofollow" href="{{ route('tmp.payment', $document->uuid) }}"
                                                class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-3 
                        bg-gradient-to-r from-blue-600 to-indigo-700 hover:from-blue-700 hover:to-indigo-800 text-white font-medium rounded-lg 
                        transition-all duration-200 shadow-md hover:shadow-lg">
                                                <span class="flex items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                    </svg>
                                                    Tải đầy đủ
                                                </span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Mobile related documents (shown only on mobile) -->
                    <div class="lg:hidden mb-6">
                        @includeWhen(Agent::isMobile(), 'components.documents.list-related')
                    </div>
                </div>
            </div>
        </div>

        @include('components.documents.detail-info')

        @include('components.documents.detail-topical')


        <div class="fixed bottom-0 left-0 right-0 z-20 bg-gradient-to-t from-white to-transparent pb-4 pt-6">
            <div class="container mx-auto px-4">
                <div
                    class="rounded-xl bg-white shadow-2xl border border-slate-200 p-4 flex flex-col md:flex-row items-center justify-between max-w-7xl mx-auto">
                    <!-- Document info -->
                    <div class="mb-3 md:mb-0 text-left">
                        <p class="text-lg font-medium text-gray-800">Tài liệu của bạn đã sẵn sàng!</p>
                        <div class="flex items-center text-sm text-gray-500 mt-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                                stroke="#FA8072">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <span>{{ Formatter::humanReadable($document->number_page) }} Trang</span>
                            <span class="mx-2">•</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                                stroke="#FA8072">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                            </svg>
                            <span>{{ Formatter::byteFormat($document->file_size) }}</span>
                        </div>
                    </div>
                    <!-- Download button -->
                    <a rel="nofollow" href="{{ route('tmp.payment', $document->uuid) }}"
                        class="w-full md:w-auto px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-700 hover:from-blue-700 hover:to-indigo-800 text-white font-medium rounded-lg flex items-center justify-center transition-all duration-200 transform hover:scale-105 shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        <span>Tải xuống ngay</span>
                    </a>
                </div>
            </div>
        </div>

        <x-back-to-top />
    @endif
@endsection
