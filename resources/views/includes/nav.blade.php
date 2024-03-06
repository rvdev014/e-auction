@php use App\Enums\LotStatus; @endphp
<header class="header-area style-1">
    <div class="header-logo">
        <a href="{{ route('home') }}" wire:navigate>
            <img alt="image" src="{{ asset('auction-app/assets/images/bg/header-logo.png') }}"/>
        </a>
    </div>
    <div class="main-menu">
        <div class="mobile-logo-area d-lg-none d-flex justify-content-between align-items-center">
            <div class="mobile-logo-wrap ">
                <a href="{{ route('home') }}" wire:navigate>
                    <img alt="image" src="{{ asset('auction-app/assets/images/bg/header-logo.png') }}"/>
                </a>
            </div>
            <div class="menu-close-btn">
                <i class="bi bi-x-lg"></i>
            </div>
        </div>
        <ul class="menu-list">
            <li class="menu-item-has-children">
                <a href="#" wire:navigate>Лотлар</a>
                <i class='bx bx-plus dropdown-icon'></i>
                <ul class="submenu">
                    <li><a href="{{ route('lots', LotStatus::Active) }}" wire:navigate>Фаол</a></li>
                    <li><a href="{{ route('lots', LotStatus::Ended) }}" wire:navigate>Савдоси тугаган</a></li>
                    <li><a href="{{ route('lots', LotStatus::Cancelled) }}" wire:navigate>Бекор килинган</a></li>
                </ul>
            </li>

            @if (Auth::check())
                <li>
                    <a href="{{ route('user.profile') }}" wire:navigate>
                        Менинг аккаунтим
                    </a>
                </li>
                <li>
                    <a href="{{ route('logout') }}">
                        Чиқиш
                    </a>
                </li>
            @else
                <li>
                    <a href="{{ route('register') }}" wire:navigate>Рўйхатдан ўтиш</a>
                </li>
                <li>
                    <a href="{{ route('login') }}" wire:navigate>Тизимга кириш</a>
                </li>
            @endif
        </ul>

    </div>
</header>
