@php
    /** @var App\Models\Lot $lot */
    $isLotStarted = $lot->starts_at < now() && $lot->ends_at > now();
@endphp

<div class="bid-list-area" @if($isLotStarted) wire:poll.visible.5s @endif>
    <div class="bid-step-header">
        <h3 class="bid-title">Ставкалар тарихи</h3>
        @if($isLotStarted)
            <button class="eg-btn btn--primary btn--sm" wire:click="$refresh">Йангилаш</button>
        @endif
    </div>

    <ul class="bid-list">
        @if ($lot->activeSteps->isEmpty())
            <div class="row d-flex align-items-center">
                <div class="col-12">
                    <div class="bidder-area">
                        <div class="bidder-content">
                            <h6>Ставкалар мавжуд эмас</h6>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @foreach($lot->activeSteps as $step)
            <li>
                <div class="row d-flex align-items-center">
                    <div class="col-7">
                        <div class="bidder-area">
                            <div class="bidder-img">
                                <img alt="image" src="{{ asset('auction/assets/images/empty-avatar.png') }}"/>
                            </div>
                            <div class="bidder-content">
                                <h6>{{ $step->user->name }}</h6>
                                <p>{{ $step->price }} сўм</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-5 text-end">
                        <div class="bid-time">
                            <p>{{ $step->updated_at->format('d-M H:i') }}</p>
                        </div>
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
</div>
