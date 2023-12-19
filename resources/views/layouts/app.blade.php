<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

    <link rel="stylesheet" href="{{ asset('assets/css/main.min.css') }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    @include('includes.counters')
    {!! SEOMeta::generate() !!}

</head>
<body>

@include('includes.header')

<main>
    <!-- Start content page -->
    @yield('content')
    <!-- End content page -->
</main>
@include('includes.footer')
<script src="{{ asset('assets/js/main.min.js') }}"></script>
@stack('scripts')
@include('includes.modals')
</body>
</html>
