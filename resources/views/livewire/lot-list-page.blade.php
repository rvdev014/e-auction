@php
    /** @var App\Models\Lot[] $lots */
@endphp

<div class="live-auction-section pt-120 pb-120">
    <img alt="image" src="{{ asset('auction/assets/images/bg/section-bg.png') }}" class="img-fluid section-bg-top">
    <img alt="image" src="{{ asset('auction/assets/images/bg/section-bg.png') }}" class="img-fluid section-bg-bottom">
    <div class="container">
        <div class="row gy-4 mb-60 d-flex justify-content-center">
            @foreach($lots as $lot)
                @include('livewire.components.lot-item-card', ['lot' => $lot])
            @endforeach
        </div>
        {{--@if ($lots->hasPages())
            <div class="row">
                {{$lots->links()}}
            </div>
        @endif--}}
    </div>
</div>
