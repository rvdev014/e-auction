<div class="col-lg-4 col-md-6 col-sm-10 ">
    <div data-wow-duration="1.5s" data-wow-delay="0.2s" class="eg-card auction-card1 wow fadeInDown">
        <div class="auction-img">
            @if (!$lot->lotable->mediaAttachments->isEmpty())
                <img alt="image" src="{{ asset('storage/' . $lot->lotable->mediaAttachments[0]?->file_path) }}">
            @endif
        </div>
        <div class="auction-content">
            <h4><a href="{{ route('lot.details', $lot->id) }}">{{ $lot->lotable->name }}</a></h4>
            <p>Bidding Price : <span>{{ $lot->starting_price }}</span></p>
        </div>
    </div>
</div>
