<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('myupload.title') }}</title>
        

        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">

        <!-- Styles -->
        
        <link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.8.2/css/all.css'> 
        <link rel="stylesheet" href="{{ asset('css/dropzone.min.css') }}">
        <link href="{{ asset('assets/main.css') }}" rel="stylesheet">

    </head>
    <body>
    
        @yield('header')

        @include('layouts.partials.toasts')
        
        @yield('layout-content')

        @section('footer')
            @include('layouts.partials.footer')
        @show
        
        @if(env('GA_PROPERTY_ID'))
            <!-- Global site tag (gtag.js) - Google Analytics -->
            <script async src="https://www.googletagmanager.com/gtag/js?id={{ env('GA_PROPERTY_ID') }}"></script>
            <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', '{{ env('GA_PROPERTY_ID') }}');
            </script>
        @endif

        <script>
            window.UPLOAD_FILE_TYPES = "{{ env('UPLOAD_FILE_TYPES') }}";
        </script>
        <script src="https://cdn.jsdelivr.net/npm/exif-js"></script>
        <script src='https://www.google.com/recaptcha/api.js'></script>
        <script src="{{ asset('assets/bundle.js') }}"></script>
    </body>
</html>
