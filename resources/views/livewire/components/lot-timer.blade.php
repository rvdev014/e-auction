@php
/** @var App\Models\Lot $lot */
@endphp

@if($lot->hasSteps())
    <div class="bid-form" wire:ignore>
        <div class="form-title">
            <h5>Ставка бериш вақти тугагунча:</h5>
            <p>Тугагунча: <span id="ends_time" class="lot-timer" data-starts="{{ $lot->lastStep->created_at }}">{{ $this->endsTimer }}</span></p>
        </div>
    </div>
@endif

@script
<script>
    const endsTimer = document.getElementById("ends_time");
    if (endsTimer) {
        const startTime = new Date(endsTimer.dataset.starts).getTime();
        // endsTime is + 10 minutes
        const endsTime = startTime + 40 * 60 * 1000;

        function getTimeLeft(distance) {
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            const minutesStr = minutes.toString().length < 2 ? "0" + minutes : minutes;
            const secondsStr = seconds.toString().length < 2 ? "0" + seconds : seconds;

            return minutesStr + ":" + secondsStr;
        }

        if (endsTime - startTime > 0) {
            const x = setInterval(function () {
                const now = new Date().getTime();
                const distance =  endsTime - now;
                if (distance > 0) {
                    endsTimer.innerHTML = getTimeLeft(distance);
                } else {
                    if (distance <= 0) {
                        $wire.dispatch('lot_started')
                        location.reload();
                        clearInterval(x);
                    }
                }
            }, 1000);
        }

    }
</script>
@endscript
