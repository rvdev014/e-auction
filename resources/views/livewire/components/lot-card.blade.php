@php
    /** @var App\Models\Lot $lot */
@endphp

<div class="col-lg-4 col-md-6 col-sm-10 ">
    <div class="eg-card c-feature-card1 wow animate fadeInDown" data-wow-duration="1.5s"
         data-wow-delay="0.2s">
        <div class="auction-img">
            @include('livewire.components.lot-image', ['lot' => $lot])
        </div>
        <div class="c-feature-content">
            <div class="c-feature-category">
                @if ($lot->lotable->categories->isNotEmpty())
                    @foreach($lot->lotable->categories as $category)
                        {{ $category->title }}
                    @endforeach
                @endif
            </div>
            <a href="{{ route('lot.details', $lot->id) }}" wire:navigate>
                <h4>{{ $lot->lotable->name }}</h4>
            </a>
            <p>Бошланих нархи: <span>{{ $lot->starting_price }}</span> сўм</p>
            <div class="auction-card-bttm">
                <a href="{{ route('lot.details', $lot->id) }}" wire:navigate class="eg-btn btn--primary btn--sm">
                    Батафсил
                </a>
                <div class="share-area">
                    <b>#{{ $lot->number }}</b>
                </div>
            </div>
        </div>
    </div>
</div>
