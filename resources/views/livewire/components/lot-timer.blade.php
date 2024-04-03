@php
/** @var App\Models\Lot $lot */
@endphp

@if($lot->isStarted())
    <div class="bid-form" wire:ignore>
        <div class="form-title">
            <h5>Аукцион бошланган</h5>
            <p>Тугагунча: <span id="ends_time" class="lot-timer">---</span></p>
        </div>
    </div>
@endif
