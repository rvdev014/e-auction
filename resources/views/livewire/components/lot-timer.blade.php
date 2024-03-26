@php
/** @var App\Models\Lot $lot */
@endphp

{{--    TIMER   --}}
@if($lot->starts_at > now())
    <div class="bid-form" wire:ignore>
        <div class="form-title">
            <h5>Аукцион бошланмаган</h5>
            <p>Аукцион бошлагунча: <span id="start_time" class="lot-timer">---</span></p>
        </div>
    </div>
@elseif($lot->isStarted())
    <div class="bid-form" wire:ignore>
        <div class="form-title">
            <h5>Аукцион бошланган</h5>
            <p>Тугагунча: <span id="ends_time" class="lot-timer">---</span></p>
        </div>
    </div>
@endif

{{--    TIMER    --}}

@script
<script>

    const startTime = new Date('{{ $lot->starts_at }}').getTime();
    const endsTime = new Date('{{ $lot->ends_at }}').getTime();
    const now = new Date().getTime();

    function getDateLeft(distance) {
        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

        return days + "д " + hours + "ч " + minutes + "м " + seconds + "с";
    }

    let distanceToStart = startTime - now;
    let distanceToEnd = endsTime - now;

    if (distanceToStart > 0) {
        const x = setInterval(function () {
            const now = new Date().getTime();
            const distance = startTime - now;
            if (distance > 0 && document.getElementById("start_time")) {
                document.getElementById("start_time").innerHTML = getDateLeft(distance);
            } else {
                if (distance <= 0) {
                    $wire.dispatch('lot_started')
                    clearInterval(x);
                }
            }
        }, 1000);
    }

    if (distanceToStart < 0 && distanceToEnd > 0) {
        const x = setInterval(function () {
            const now = new Date().getTime();
            const distance = endsTime - now;
            if (distance > 0 && document.getElementById("ends_time")) {
                document.getElementById("ends_time").innerHTML = getDateLeft(distance);
            } else {
                if (distance <= 0) {
                    $wire.dispatch('lot_ended')
                    clearInterval(x);
                }
            }
        }, 1000);
    }

</script>
@endscript
