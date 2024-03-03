<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? config('app.name') }}</title>
    <link rel="icon" href="{{ asset('auction/assets/images/bg/sm-logo.png') }}" type="image/gif" sizes="20x20">
    <link rel="stylesheet" href="{{ asset('auction/assets/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('auction/assets/css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('auction/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('auction/assets/css/boxicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('auction/assets/css/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('auction/assets/css/jquery-ui.css') }}">
    <link rel="stylesheet" href="{{ asset('auction/assets/css/swiper-bundle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('auction/assets/css/slick-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('auction/assets/css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('auction/assets/css/nice-select.css') }}">
    <link rel="stylesheet" href="{{ asset('auction/assets/css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('auction/assets/css/odometer.css') }}">
    <link rel="stylesheet" href="{{ asset('auction/assets/css/style.css') }}">

    @livewireStyles
</head>

<body>
@include('includes.nav')

@include('includes.alerts')
{{ $slot }}

@include('includes.footer')

<script src="{{ asset('auction/assets/js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('auction/assets/js/jquery-ui.js') }}"></script>
<script src="{{ asset('auction/assets/js/bootstrap.bundle.min.js') }}"></script>
{{--<script src="{{ asset('auction/assets/js/wow.min.js') }}"></script>--}}
<script src="{{ asset('auction/assets/js/swiper-bundle.min.js') }}"></script>
<script src="{{ asset('auction/assets/js/slick.js') }}"></script>
<script src="{{ asset('auction/assets/js/jquery.nice-select.js') }}"></script>
<script src="{{ asset('auction/assets/js/odometer.min.js') }}"></script>
<script src="{{ asset('auction/assets/js/viewport.jquery.js') }}"></script>
<script src="{{ asset('auction/assets/js/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ asset('auction/assets/js/main.js') }}"></script>
@livewireScripts
</body>

</html>
