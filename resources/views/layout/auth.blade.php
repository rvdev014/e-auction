<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="icon" href="{{ asset('auction/assets/images/bg/sm-logo.png') }}" type="image/gif" sizes="20x20">
    <link rel="stylesheet" href="{{ asset('auction/assets/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('auction/assets/css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('auction/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('auction/assets/css/style.css') }}">
</head>
<body>
@yield('content')
</body>
</html>
