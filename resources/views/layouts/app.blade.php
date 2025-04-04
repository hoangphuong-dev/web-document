<!DOCTYPE html>
<html lang="vi">

<head>
    @php $urlFavicon = url('/favicon.ico'); @endphp
    <meta charset="UTF-8">
    <meta name="google-adsense-account" content="{{ config('app.google_adsense') }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=2">
    <link type="image/x-icon" rel="shortcut icon" href="{{ $urlFavicon }}" />
    <link rel="icon" href="{{ $urlFavicon }}" type="image/x-icon">
    {{-- SEO generate --}}
    {!! SEOMeta::generate() !!}
    {!! OpenGraph::generate() !!}
    {!! Twitter::generate() !!}
    {!! JsonLd::generate() !!}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/style.css', 'resources/css/app.css'])
    @stack('css')
    @stack('after_scripts')

    @include('layouts.clarity')
    @include('layouts.google-analytics')
    @livewireStyles
</head>

<body>
    @include('layouts.header')

    <div class="container mx-auto max-w-screen-xl">
        @yield('content')
    </div>

    <div>@livewire('wire-elements-modal')</div>

    @include('layouts.footer')

    @vite('resources/js/app.js')
    @stack('scripts')
    @include('layouts.app-js')
    
    @livewireScripts
</body>

</html>
