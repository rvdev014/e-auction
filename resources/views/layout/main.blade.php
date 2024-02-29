<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bidout - Auction and Bidding HTML Template</title>
    <link rel="icon" href="{{ asset('auction/assets/images/bg/sm-logo.png') }}" type="image/gif" sizes="20x20">

    <link rel="stylesheet" href="{{ asset('auction/assets/css/animate.css') }}">
    <!-- css file link -->
    <link rel="stylesheet" href="{{ asset('auction/assets/css/all.css') }}">

    <!-- bootstrap 5 -->
    <link rel="stylesheet" href="{{ asset('auction/assets/css/bootstrap.min.css') }}">

    <!-- box-icon -->
    <link rel="stylesheet" href="{{ asset('auction/assets/css/boxicons.min.css') }}">

    <!-- bootstrap icon -->
    <link rel="stylesheet" href="{{ asset('auction/assets/css/bootstrap-icons.css') }}">

    <!-- jquery ui -->
    <link rel="stylesheet" href="{{ asset('auction/assets/css/jquery-ui.css') }}">

    <!-- swiper-slide -->
    <link rel="stylesheet" href="{{ asset('auction/assets/css/swiper-bundle.min.css') }}">

    <!-- slick-slide -->
    <link rel="stylesheet" href="{{ asset('auction/assets/css/slick-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('auction/assets/css/slick.css') }}">

    <!-- select 2 -->
    <link rel="stylesheet" href="{{ asset('auction/assets/css/nice-select.css') }}">

    <!-- animate css -->
    <link rel="stylesheet" href="{{ asset('auction/assets/css/magnific-popup.css') }}">

    <!-- odometer css -->
    <link rel="stylesheet" href="{{ asset('auction/assets/css/odometer.css') }}">

    <!-- style css -->
    <link rel="stylesheet" href="{{ asset('auction/assets/css/style.css') }}">
</head>

<body>
<!-- preloader -->
<!--    <div class="preloader">-->
<!--        <div class="loader">-->
<!--            <span></span>-->
<!--            <span></span>-->
<!--            <span></span>-->
<!--            <span></span>-->
<!--        </div>-->
<!--    </div>-->


<!-- ========== header============= -->

<header class="header-area style-1">
    <div class="header-logo">
        <a href="index.html"><img alt="image" src="{{ asset('auction/assets/images/bg/header-logo.png') }}"></a>
    </div>
    <div class="main-menu">
        <div class="mobile-logo-area d-lg-none d-flex justify-content-between align-items-center">
            <div class="mobile-logo-wrap ">
                <a href="index.html"><img alt="image" src="{{ asset('auction/assets/images/bg/header-logo.png') }}"></a>
            </div>
            <div class="menu-close-btn">
                <i class="bi bi-x-lg"></i>
            </div>
        </div>
        <ul class="menu-list">
            <li>
                <a href="index.html">
                    Бош саҳифа
                </a>
            </li>
            <li class="menu-item-has-children">
                <a href="#">
                    Лотлар
                </a><i class='bx bx-plus dropdown-icon'></i>
                <ul class="submenu">
                    <li>
                        <a href="live-auction.html">
                            Якунланган аукцион савдолари
                        </a>
                    </li>
                    <li>
                        <a href="live-auction.html">
                            Бекор қилинган аукцион савдолари
                        </a>
                    </li>
                    <li>
                        <a href="live-auction.html">
                            Жорий аукцион савдолари
                        </a>
                    </li>
                </ul>
            </li>

            @if (Auth::check())
                <li>
                    <a href="{{ route('user.profile') }}">
                        Менинг аккаунтим
                    </a>
                </li>
            @else
                <li>
                    <a href="{{ route('register') }}">Рўйхатдан ўтиш</a>
                </li>
                <li>
                    <a href="{{ route('login') }}">Тизимга кириш</a>
                </li>
            @endif
        </ul>

    </div>
</header>

@yield('content')

<!-- =============== Footer-action-section start =============== -->

<footer>
    <div class="footer-top">
        <div class="container">
            <div class="row gy-5">
                <div class="col-lg-3 col-md-6">
                    <div class="footer-item">
                        <a href="index.html"><img alt="image" src="{{ asset('auction/assets/images/bg/footer-logo.png') }}"></a>
                        <p>Lorem ipsum dolor sit amet consecte tur adipisicing elit, sed do eiusmod tempor
                            incididunt ut labore.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container">
            <div class="row d-flex align-items-center g-4">
                <div class="col-lg-6 d-flex justify-content-lg-start justify-content-center">
                    <p>Copyright 2022 <a href="#">E-auskion</a>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- =============== Footer-action-section end =============== -->

<!-- js file link -->
<script src="{{ asset('auction/assets/js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('auction/assets/js/jquery-ui.js') }}"></script>
<script src="{{ asset('auction/assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('auction/assets/js/wow.min.js') }}"></script>
<script src="{{ asset('auction/assets/js/swiper-bundle.min.js') }}"></script>
<script src="{{ asset('auction/assets/js/slick.js') }}"></script>
<script src="{{ asset('auction/assets/js/jquery.nice-select.js') }}"></script>
<script src="{{ asset('auction/assets/js/odometer.min.js') }}"></script>
<script src="{{ asset('auction/assets/js/viewport.jquery.js') }}"></script>
<script src="{{ asset('auction/assets/js/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ asset('auction/assets/js/main.js') }}"></script>

</body>

</html>
