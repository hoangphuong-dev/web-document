@extends('layouts.app')

@section('content')
    <div class="bg-white py-4 md:py-6 px-4 md:px-8 lg:px-10">

        {{ Breadcrumbs::render('search-document', $keyword) }}

        <div class="container mx-auto mb-5 md:mb-8 px-2 md:px-0 py-4">

            {{-- Filter --}}
            @include('search.filter')

            <div class="h-[1px] w-full bg-secondary"></div>
        </div>

        <h1 class="text-base md:text-xl my-3 text-center">
            Kết quả tìm kiếm với từ khóa: <span class="text-primary font-bold">{{ $keyword }}</span>
        </h1>

        <div class=" container mx-auto py-3 grid grid-cols-12 gap-2">
            <div class="col-span-12">
                <x-documents.document-item-line :documents="$documents" :hiddenDesc="false" />

                {{-- Phân trang --}}
                @include('search.paginate-search')
            </div>

        </div>
    </div>
@endsection
