@php
/** @var App\Models\Lot $lot */
@endphp

@if($lot->hasSteps())
    <div class="bid-form" wire:ignore>
        <div class="form-title">
            <h5>Ставка бериш вақти тугагунча:</h5>
            <p>Тугагунча: <span id="ends_time" class="lot-timer"></span></p>
        </div>
    </div>
@endif

@script
<script>

    const minutes = 10;
    let endsInterval = null;

    Livewire.on('refreshTimer', (stepDate) => {
        if (endsInterval) {
            clearInterval(endsInterval);
        }
        updateTimer(stepDate);
    });

    function getTimeLeft(distance) {
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

        const minutesStr = minutes.toString().length < 2 ? "0" + minutes : minutes;
        const secondsStr = seconds.toString().length < 2 ? "0" + seconds : seconds;

        return minutesStr + ":" + secondsStr;
    }

    function updateTimer(date) {
        const endsTimer = document.getElementById("ends_time");
        if (endsTimer) {
            const startTime = new Date(date).getTime();
            // endsTime is + 10 minutes
            const endsTime = startTime + minutes * 60 * 1000;

            if (endsTime - startTime > 0) {
                endsInterval = setInterval(function () {
                    const now = new Date().getTime();
                    const distance =  endsTime - now;
                    if (distance > 0) {
                        endsTimer.innerHTML = getTimeLeft(distance);
                    } else {
                        if (distance <= 0) {
                            setTimeout(() => {
                                window.location.reload();
                            }, 3000);
                        }
                    }
                }, 1000);
            }

        }
    }

    updateTimer("{{ $lot->lastStep?->created_at }}");
</script>
@endscript
