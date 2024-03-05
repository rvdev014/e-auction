@php
    /** @var App\Models\Lot[] $lots */
@endphp

<div class="live-auction-section pt-120 pb-120">
    <img alt="image" src="{{ asset('auction/assets/images/bg/section-bg.png') }}" class="img-fluid section-bg-top">
    <img alt="image" src="{{ asset('auction/assets/images/bg/section-bg.png') }}" class="img-fluid section-bg-bottom">
    <div class="container">
        <div class="row gy-4 mb-60 d-flex">
            @foreach($lots as $lot)
                <div class="col-lg-4 col-md-6 col-sm-10 ">
                    <div data-wow-duration="1.5s" data-wow-delay="0.2s" class="eg-card auction-card1 wow fadeInDown">
                        <div class="auction-img">
                            @include('livewire.components.lot-image', ['lot' => $lot])
                        </div>
                        <div class="auction-content">
                            <h4><a href="{{ route('lot.details', $lot->id) }}">{{ $lot->lotable->name }}</a></h4>
                            <p>Бошланиш нархи: <span>{{ $lot->starting_price }} сўм</span></p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        {{--@if ($lots->hasPages())
            <div class="row">
                {{$lots->links()}}
            </div>
        @endif--}}
    </div>
</div>
