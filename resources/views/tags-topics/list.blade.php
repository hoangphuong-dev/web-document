@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto py-6" id="list-result">
        <!-- Breadcrumbs placeholder with improved spacing -->
        <div class="mb-4">
            {{-- {{ Breadcrumbs::render('document-category', $category->breadcrumb) }} --}}
        </div>

        <!-- Main content card with shadow -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <!-- Instance Header with gradient background -->
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 py-5 px-4 sm:px-6 border-b border-gray-200">
                <h1 class="text-xl sm:text-2xl md:text-3xl text-center font-bold text-gray-800">
                    {{ $instance->name }}
                </h1>
            </div>

            <!-- Document listing section -->
            <div class="py-4 sm:py-6">
                <!-- SEO hidden titles and descriptions -->
                <div class="sr-only">
                    @foreach ($documents as $document)
                        <h2>{{ $document->title }}</h2>
                        @php $ai_description = $document?->metaData?->ai_description; @endphp
                        @if (!empty($ai_description))
                            <h3>{{ $ai_description }}</h3>
                        @endif
                    @endforeach
                </div>

                <!-- Documents grid with description enabled -->
                <div class="px-4 sm:px-6">
                    <x-documents.document-item-grid :documents="$documents" :isDescription=true />
                </div>
            </div>
        </div>

        <!-- Pagination with better spacing -->
        <div class="mt-8 flex justify-center">
            {{ $documents->links() }}
        </div>
    </div>
@endsection
