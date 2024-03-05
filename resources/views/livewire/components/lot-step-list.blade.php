<div class="bid-list-area" wire:poll.visible.5s>
    <div class="bid-step-header">
        <h3 class="bid-title">Кадамлар тарихи</h3>
        <button class="eg-btn btn--primary btn--sm" wire:click="$refresh">Йангилаш</button>
    </div>
    <ul class="bid-list">
        @foreach($lot->activeSteps as $step)
            <li>
                <div class="row d-flex align-items-center">
                    <div class="col-7">
                        <div class="bidder-area">
                            {{--<div class="bidder-img">
                                <img alt="image" src="assets/images/bg/bidder1.png" />
                            </div>--}}
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
