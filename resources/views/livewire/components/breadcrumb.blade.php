<div class="inner-banner">
    <div class="container">
        <h2 class="inner-banner-title  wow fadeInLeft" data-wow-duration="1.5s" data-wow-delay=".4s">
            {{ $title }}
        </h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}" wire:navigate>Бош сахифа</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
            </ol>
        </nav>
    </div>
</div>
