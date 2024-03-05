@php
use App\Enums\LotStatus;
@endphp

<div>
    <div class="hero-area hero-style-one">
        <div class="hero-main-wrapper position-relative">
            <div class="swiper banner1">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="slider-bg-1">
                            <div class="container">
                                <div class="row d-flex justify-content-center align-items-center">
                                    <div class="col-xl-10 col-lg-10">
                                        <div class="banner1-content">
                                            <span>{{ config('app.name') }}</span>
                                            <h1>Хуш келибсиз!</h1>
                                            <p>Бизнинг онлайн бозоримизда сизни кўришимиздан кҳурсандмиз!.
                                            </p>
                                            <a href="{{ route('lots', LotStatus::Active) }}" class="eg-btn btn--primary btn--lg" wire:navigate>
                                                Лотларни кўриш
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="hero-one-pagination d-flex justify-content-center flex-column align-items-center gap-3"></div>
        </div>
    </div>

    <div class="live-auction pt-80 pb-120">
        <img alt="image" src="{{ asset('auction/assets/images/bg/section-bg.png') }}" class="img-fluid section-bg">
        <div class="container position-relative">
            <img alt="image" src="{{ asset('auction/assets/images/bg/dotted1.png') }}" class="dotted1">
            <img alt="image" src="{{ asset('auction/assets/images/bg/dotted1.png') }}" class="dotted2">
            <div class="row d-flex justify-content-center">
                <div class="col-sm-12 col-md-10 col-lg-8 col-xl-6">
                    <div class="section-title1">
                        <h2>
                            Жорий аукцион савдолари
                        </h2>
                    </div>
                </div>
            </div>
            <div class="row gy-4 mb-60 d-flex justify-content-center">
                @foreach($lots as $lot)
                    @include('livewire.components.lot-card', ['lot' => $lot])
                @endforeach
            </div>
            {{--<div class="row d-flex justify-content-center">
                <div class="col-md-4 text-center">
                    <a href="live-auction.html" class="eg-btn btn--primary btn--md mx-auto">
                        Барчасини кўриш
                    </a>
                </div>
            </div>--}}
        </div>
    </div>

    {{--<div class="upcoming-seciton pb-120">
        <img alt="image" src="{{ asset('auction/assets/images/bg/section-bg.png') }}" class="img-fluid section-bg">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-sm-12 col-md-10 col-lg-8 col-xl-6">
                    <div class="section-title1">
                        <h2>
                            Якунланган аукцион савдолари
                        </h2>
                    </div>
                </div>
            </div>
            <div class="row d-flex justify-content-center">
                <div class="swiper upcoming-slider">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="eg-card c-feature-card1 wow animate fadeInDown" data-wow-duration="1.5s"
                                 data-wow-delay="0.2s">
                                <div class="auction-img">
                                    <img alt="image" src="{{ asset('auction/assets/images/bg/umcoming1.png') }}">
                                    <div class="auction-timer2 gap-lg-3 gap-md-2 gap-1" id="timer7">
                                        <div class="countdown-single">
                                            <h5 id="days7">7</h5>
                                            <span>Days</span>
                                        </div>
                                        <div class="countdown-single">
                                            <h5 id="hours7">05</h5>
                                            <span>Hours</span>
                                        </div>
                                        <div class="countdown-single">
                                            <h5 id="minutes7">56</h5>
                                            <span>Mins</span>
                                        </div>
                                        <div class="countdown-single">
                                            <h5 id="seconds7">08</h5>
                                            <span>Secs</span>
                                        </div>
                                    </div>
                                    <div class="author-area2">
                                        <div class="author-name">
                                            <span>by @robatfox</span>
                                        </div>
                                        <div class="author-emo">
                                            <img alt="image"
                                                 src="{{ asset('auction/assets/images/bg/upcoming-author1.png') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="c-feature-content">
                                    <div class="c-feature-category">Time Zoon</div>
                                    <a href="auction-details.html">
                                        <h4>Michael Korian Gold Special Watch m20L6 Bidding</h4>
                                    </a>
                                    <p>Bidding Price : <span>$15.99</span></p>
                                    <div class="auction-card-bttm">
                                        <a href="auction-details.html" class="eg-btn btn--primary btn--sm">View
                                            Details</a>
                                        <div class="share-area">
                                            <ul class="social-icons d-flex">
                                                <li><a href="https://www.facebook.com/"><i class="bx bxl-facebook"></i></a>
                                                </li>
                                                <li><a href="https://www.twitter.com/"><i
                                                            class="bx bxl-twitter"></i></a></li>
                                                <li><a href="https://www.pinterest.com/"><i
                                                            class="bx bxl-pinterest"></i></a></li>
                                                <li><a href="https://www.instagram.com/"><i
                                                            class="bx bxl-instagram"></i></a></li>
                                            </ul>
                                            <div>
                                                <div class="share-btn"><i class='bx bxs-share-alt'></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="eg-card c-feature-card1 wow animate fadeInDown" data-wow-duration="1.5s"
                                 data-wow-delay="0.4s">
                                <div class="auction-img">
                                    <img alt="image" src="{{ asset('auction/assets/images/bg/umcoming2.png') }}">
                                    <div class="auction-timer2 gap-lg-3 gap-md-2 gap-1" id="timer8">
                                        <div class="countdown-single">
                                            <h5 id="days8">7</h5>
                                            <span>Days</span>
                                        </div>
                                        <div class="countdown-single">
                                            <h5 id="hours8">05</h5>
                                            <span>Hours</span>
                                        </div>
                                        <div class="countdown-single">
                                            <h5 id="minutes8">56</h5>
                                            <span>Mins</span>
                                        </div>
                                        <div class="countdown-single">
                                            <h5 id="seconds8">08</h5>
                                            <span>Secs</span>
                                        </div>
                                    </div>
                                    <div class="author-area2">
                                        <div class="author-name">
                                            <span>by @robatfox</span>
                                        </div>
                                        <div class="author-emo">
                                            <img alt="image"
                                                 src="{{ asset('auction/assets/images/bg/upcoming-author2.png') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="c-feature-content">
                                    <div class="c-feature-category">Lit Gaslighte</div>
                                    <a href="auction-details.html">
                                        <h4>Watercolor Special Lighter 2.2 For Saleing Offer</h4>
                                    </a>
                                    <p>Bidding Price : <span>$15.99</span></p>
                                    <div class="auction-card-bttm">
                                        <a href="auction-details.html" class="eg-btn btn--primary btn--sm">View
                                            Details</a>
                                        <div class="share-area">
                                            <ul class="social-icons d-flex">
                                                <li><a href="https://www.facebook.com/"><i class="bx bxl-facebook"></i></a>
                                                </li>
                                                <li><a href="https://www.twitter.com/"><i
                                                            class="bx bxl-twitter"></i></a></li>
                                                <li><a href="https://www.pinterest.com/"><i
                                                            class="bx bxl-pinterest"></i></a></li>
                                                <li><a href="https://www.instagram.com/"><i
                                                            class="bx bxl-instagram"></i></a></li>
                                            </ul>
                                            <div>
                                                <a href="#" class="share-btn"><i class='bx bxs-share-alt'></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="eg-card c-feature-card1 wow animate fadeInDown" data-wow-duration="1.5s"
                                 data-wow-delay="0.6s">
                                <div class="auction-img">
                                    <img alt="image" src="{{ asset('auction/assets/images/bg/umcoming3.png') }}">
                                    <div class="auction-timer2 gap-lg-3 gap-md-2 gap-1" id="timer9">
                                        <div class="countdown-single">
                                            <h5 id="days9">7</h5>
                                            <span>Days</span>
                                        </div>
                                        <div class="countdown-single">
                                            <h5 id="hours9">05</h5>
                                            <span>Hours</span>
                                        </div>
                                        <div class="countdown-single">
                                            <h5 id="minutes9">56</h5>
                                            <span>Mins</span>
                                        </div>
                                        <div class="countdown-single">
                                            <h5 id="seconds9">08</h5>
                                            <span>Secs</span>
                                        </div>
                                    </div>
                                    <div class="author-area2">
                                        <div class="author-name">
                                            <span>by @robatfox</span>
                                        </div>
                                        <div class="author-emo">
                                            <img alt="image"
                                                 src="{{ asset('auction/assets/images/bg/upcoming-author3.png') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="c-feature-content">
                                    <div class="c-feature-category">Motor Bike</div>
                                    <a href="auction-details.html">
                                        <h4>BMW AIGID A Class Hatch M26 Motor Bike</h4>
                                    </a>
                                    <p>Bidding Price : <span>$15.99</span></p>
                                    <div class="auction-card-bttm">
                                        <a href="auction-details.html" class="eg-btn btn--primary btn--sm">View
                                            Details</a>
                                        <div class="share-area">
                                            <ul class="social-icons d-flex">
                                                <li><a href="https://www.facebook.com/"><i class="bx bxl-facebook"></i></a>
                                                </li>
                                                <li><a href="https://www.twitter.com/"><i
                                                            class="bx bxl-twitter"></i></a></li>
                                                <li><a href="https://www.pinterest.com/"><i
                                                            class="bx bxl-pinterest"></i></a></li>
                                                <li><a href="https://www.instagram.com/"><i
                                                            class="bx bxl-instagram"></i></a></li>
                                            </ul>
                                            <div>
                                                <a href="#" class="share-btn"><i class='bx bxs-share-alt'></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="eg-card c-feature-card1 wow animate fadeInDown" data-wow-duration="1.5s"
                                 data-wow-delay=".8s">
                                <div class="auction-img">
                                    <img alt="image" src="{{ asset('auction/assets/images/bg/umcoming4.png') }}">
                                    <div class="auction-timer2 gap-lg-3 gap-md-2 gap-1" id="timer10">
                                        <div class="countdown-single">
                                            <h5 id="days10">7</h5>
                                            <span>Days</span>
                                        </div>
                                        <div class="countdown-single">
                                            <h5 id="hours10">05</h5>
                                            <span>Hours</span>
                                        </div>
                                        <div class="countdown-single">
                                            <h5 id="minutes10">56</h5>
                                            <span>Mins</span>
                                        </div>
                                        <div class="countdown-single">
                                            <h5 id="seconds10">08</h5>
                                            <span>Secs</span>
                                        </div>
                                    </div>
                                    <div class="author-area2">
                                        <div class="author-name">
                                            <span>by @robatfox</span>
                                        </div>
                                        <div class="author-emo">
                                            <img alt="image"
                                                 src="{{ asset('auction/assets/images/bg/upcoming-author1.png') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="c-feature-content">
                                    <div class="c-feature-category">Test Watch</div>
                                    <a href="auction-details.html">
                                        <h4>Microlab Amazing Head-phone With Adapter</h4>
                                    </a>
                                    <p>Bidding Price : <span>$15.99</span></p>
                                    <div class="auction-card-bttm">
                                        <a href="auction-details.html" class="eg-btn btn--primary btn--sm">View
                                            Details</a>
                                        <div class="share-area">
                                            <ul class="social-icons d-flex">
                                                <li><a href="https://www.facebook.com/"><i class="bx bxl-facebook"></i></a>
                                                </li>
                                                <li><a href="https://www.twitter.com/"><i
                                                            class="bx bxl-twitter"></i></a></li>
                                                <li><a href="https://www.pinterest.com/"><i
                                                            class="bx bxl-pinterest"></i></a></li>
                                                <li><a href="https://www.instagram.com/"><i
                                                            class="bx bxl-instagram"></i></a></li>
                                            </ul>
                                            <div>
                                                <a href="#" class="share-btn"><i class='bx bxs-share-alt'></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="slider-bottom d-flex justify-content-between align-items-center">
                    <a href="live-auction.html" class="eg-btn btn--primary btn--md">View ALL</a>
                    <div class="swiper-pagination style-3 d-lg-block d-none"></div>
                    <div class="slider-arrows coming-arrow d-flex gap-3">
                        <div class="coming-prev1 swiper-prev-arrow" tabindex="0" role="button"
                             aria-label="Previous slide"><i
                                class="bi bi-arrow-left"></i></div>
                        <div class="coming-next1 swiper-next-arrow" tabindex="0" role="button" aria-label="Next slide">
                            <i
                                class="bi bi-arrow-right"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>--}}

    <div class="testimonial-section pt-80 pb-80">
        <img alt="image" src="{{ asset('auction/assets/images/bg/client-right.png') }}" class="client-right-vector">
        <img alt="image" src="{{ asset('auction/assets/images/bg/client-left.png') }}" class="client-left-vector">
        <img alt="image" src="{{ asset('auction/assets/images/bg/clent-circle1.png') }}" class="client-circle1">
        <img alt="image" src="{{ asset('auction/assets/images/bg/clent-circle2.png') }}" class="client-circle2">
        <img alt="image" src="{{ asset('auction/assets/images/bg/clent-circle3.png') }}" class="client-circle3">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-sm-12 col-md-10 col-lg-8 col-xl-6">
                    <div class="section-title1">
                        <h2>What Client Say</h2>
                        <p class="mb-0">Explore on the world's best & largest Bidding marketplace with our beautiful
                            Bidding
                            products. We want to be a part of your smile, success and future growth.</p>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center position-relative">
                <div class="swiper testimonial-slider">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="testimonial-single hover-border1 wow fadeInDown" data-wow-duration="1.5s"
                                 data-wow-delay=".2s">
                                <img alt="image" src="{{ asset('auction/assets/images/icons/quote-green.svg') }}"
                                     class="quote-icon">
                                <div class="testi-img">
                                    <img alt="image" src="{{ asset('auction/assets/images/bg/testi1.png') }}">
                                </div>
                                <div class="testi-content">
                                    <p class="para">The Pacific Grove Chamber of Commerce would like to thank eLab
                                        Communications and Mr. Will Elkadi for all the efforts that
                                        assisted me nicely manners.</p>
                                    <div class="testi-designation">
                                        <h5><a href="blog.html">Johan Martin</a></h5>
                                        <p>CEO</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="testimonial-single hover-border1 wow fadeInDown" data-wow-duration="1.5s"
                                 data-wow-delay=".4s">
                                <img alt="image" src="{{ asset('auction/assets/images/icons/quote-green.svg') }}"
                                     class="quote-icon">
                                <div class="testi-img">
                                    <img alt="image" src="{{ asset('auction/assets/images/bg/testi2.png') }}">
                                </div>
                                <div class="testi-content">
                                    <p class="para">Nullam cursus tempor ex. Nullam nec dui id metus consequat congue ac
                                        at est.
                                        Pellentesque blandit neque at elit tristique tincidunt.</p>
                                    <div class="testi-designation">
                                        <h5><a href="#">Jamie anderson</a></h5>
                                        <p>Manager</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="testimonial-single hover-border1 wow fadeInDown" data-wow-duration="1.5s"
                                 data-wow-delay=".4s">
                                <img alt="image" src="{{ asset('auction/assets/images/icons/quote-green.svg') }}"
                                     class="quote-icon">
                                <div class="testi-img">
                                    <img alt="image" src="{{ asset('auction/assets/images/bg/testi3.png') }}">
                                </div>
                                <div class="testi-content">
                                    <p class="para">Maecenas vitae porttitor neque, ac porttitor nunc. Duis venenatis
                                        lacinia libero. Nam
                                        nec augue ut nunc vulputate tincidunt at suscipit nunc. </p>
                                    <div class="testi-designation">
                                        <h5><a href="#">John Peter</a></h5>
                                        <p>Area Manager</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="slider-arrows testimonial2-arrow d-flex justify-content-between gap-3">
                    <div class="testi-prev1 swiper-prev-arrow" tabindex="0" role="button"
                         aria-label="Previous slide"><i class="bi bi-arrow-left"></i></div>
                    <div class="testi-next1 swiper-next-arrow" tabindex="0" role="button"
                         aria-label="Next slide">
                        <i class="bi bi-arrow-right"></i></div>
                </div>
            </div>
        </div>
    </div>

    <div class="sponsor-section style-1 pb-4 mb-60">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-sm-12 col-md-10 col-lg-8 col-xl-6">
                    <div class="section-title1">
                        <h2>Trusted By 500+ Businesses.</h2>
                        <p class="mb-0">Explore on the world's best & largest Bidding marketplace with our beautiful
                            Bidding
                            products. We want to be a part of your smile, success and future growth.</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="slick-wrapper wow fadeInUp" data-wow-duration="1.5s" data-wow-delay="0.2s">
                    <div id="slick1">
                        <div class="slide-item"><img alt="image"
                                                     src="{{ asset('auction/assets/images/bg/sponsor1.png') }}"></div>
                        <div class="slide-item"><img alt="image"
                                                     src="{{ asset('auction/assets/images/bg/sponsor2.png') }}"></div>
                        <div class="slide-item"><img alt="image"
                                                     src="{{ asset('auction/assets/images/bg/sponsor3.png') }}"></div>
                        <div class="slide-item"><img alt="image"
                                                     src="{{ asset('auction/assets/images/bg/sponsor4.png') }}"></div>
                        <div class="slide-item"><img alt="image"
                                                     src="{{ asset('auction/assets/images/bg/sponsor5.png') }}"></div>
                        <div class="slide-item"><img alt="image"
                                                     src="{{ asset('auction/assets/images/bg/sponsor6.png') }}"></div>
                        <div class="slide-item"><img alt="image"
                                                     src="{{ asset('auction/assets/images/bg/sponsor7.png') }}"></div>
                        <div class="slide-item"><img alt="image"
                                                     src="{{ asset('auction/assets/images/bg/sponsor8.png') }}"></div>
                        <div class="slide-item"><img alt="image"
                                                     src="{{ asset('auction/assets/images/bg/sponsor9.png') }}"></div>
                        <div class="slide-item"><img alt="image"
                                                     src="{{ asset('auction/assets/images/bg/sponsor1.png') }}"></div>
                        <div class="slide-item"><img alt="image"
                                                     src="{{ asset('auction/assets/images/bg/sponsor3.png') }}"></div>
                        <div class="slide-item"><img alt="image"
                                                     src="{{ asset('auction/assets/images/bg/sponsor5.png') }}"></div>
                        <div class="slide-item"><img alt="image"
                                                     src="{{ asset('auction/assets/images/bg/sponsor8.png') }}"></div>
                        <div class="slide-item"><img alt="image"
                                                     src="{{ asset('auction/assets/images/bg/sponsor6.png') }}"></div>
                        <div class="slide-item"><img alt="image"
                                                     src="{{ asset('auction/assets/images/bg/sponsor7.png') }}"></div>
                        <div class="slide-item"><img alt="image"
                                                     src="{{ asset('auction/assets/images/bg/sponsor8.png') }}"></div>
                        <div class="slide-item"><img alt="image"
                                                     src="{{ asset('auction/assets/images/bg/sponsor1.png') }}"></div>
                        <div class="slide-item"><img alt="image"
                                                     src="{{ asset('auction/assets/images/bg/sponsor2.png') }}"></div>
                        <div class="slide-item"><img alt="image"
                                                     src="{{ asset('auction/assets/images/bg/sponsor9.png') }}"></div>
                        <div class="slide-item"><img alt="image"
                                                     src="{{ asset('auction/assets/images/bg/sponsor8.png') }}"></div>
                        <div class="slide-item"><img alt="image"
                                                     src="{{ asset('auction/assets/images/bg/sponsor9.png') }}"></div>
                        <div class="slide-item"><img alt="image"
                                                     src="{{ asset('auction/assets/images/bg/sponsor1.png') }}"></div>
                        <div class="slide-item"><img alt="image"
                                                     src="{{ asset('auction/assets/images/bg/sponsor3.png') }}"></div>
                        <div class="slide-item"><img alt="image"
                                                     src="{{ asset('auction/assets/images/bg/sponsor5.png') }}"></div>
                        <div class="slide-item"><img alt="image"
                                                     src="{{ asset('auction/assets/images/bg/sponsor8.png') }}"></div>
                        <div class="slide-item"><img alt="image"
                                                     src="{{ asset('auction/assets/images/bg/sponsor6.png') }}"></div>
                        <div class="slide-item"><img alt="image"
                                                     src="{{ asset('auction/assets/images/bg/sponsor7.png') }}"></div>
                        <div class="slide-item"><img alt="image"
                                                     src="{{ asset('auction/assets/images/bg/sponsor8.png') }}"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
