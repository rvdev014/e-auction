@php
    /** @var App\Models\Lot $lot */
@endphp

<div class="bid-list-area" @if($lot->isStarted()) wire:poll.visible.5s @endif>
    <div class="bid-step-header">
        <h3 class="bid-title">Ставкалар тарихи</h3>
        @if($lot->isStarted())
            <button class="eg-btn btn--primary btn--sm" wire:click="$refresh">Йангилаш</button>
        @endif
    </div>

    <ul class="bid-list">
        @if ($lot->steps->isEmpty())
            <div class="alert alert-warning">
                Ставкалар мавжуд эмас
            </div>
        @endif
        @foreach($lot->steps as $step)
            <li>
                <div class="row d-flex align-items-center">
                    <div class="col-7">
                        <div class="bidder-area">
                            <div class="bidder-img">
                                <img alt="image" src="{{ asset('auction-app/assets/images/empty-avatar.png') }}"/>
                            </div>
                            <div class="bidder-content">
                                <h6 style="margin-bottom: 0">
                                    {{ $step->lotUser->user->name }} (#{{ $step->lotUser->user->lots_member_number }})
                                    @if ($step->lotUser->is_winner)
                                        <span class="badge bg-success">Голиб</span>
                                    @endif
                                </h6>
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
