@php
    /** @var App\Models\Lot $lot */
    $images = $lot->lotable->mediaAttachments;
@endphp

<div class="auction-details-section">
    <img alt="image" src="{{ asset('auction/assets/images/bg/section-bg.png') }}" class="img-fluid section-bg-top">
    <img alt="image" src="{{ asset('auction/assets/images/bg/section-bg.png') }}" class="img-fluid section-bg-bottom">
    <div class="container">
        <div class="row g-4 mb-50">
            <div
                    class="col-xl-6 col-lg-7 d-flex flex-row align-items-start justify-content-lg-start justify-content-center flex-md-nowrap flex-wrap gap-4">
                <ul class="nav small-image-list d-flex flex-md-column flex-row justify-content-center gap-4  wow fadeInDown"
                    data-wow-duration="1.5s" data-wow-delay=".4s">

                    @foreach($images as $image)
                        <li class="nav-item">
                            <div id="details-img{{ $loop->index + 4 }}" data-bs-toggle="pill"
                                 data-bs-target="#gallery-img{{ $loop->index + 4 }}"
                                 aria-controls="gallery-img{{ $loop->index + 4 }}">
                                <img alt="image" src="{{ asset('storage/' . $image->file_path) }}"
                                     class="img-fluid">
                            </div>
                        </li>
                    @endforeach

                </ul>
                <div class="tab-content mb-4 d-flex justify-content-lg-start justify-content-center  wow fadeInUp"
                     data-wow-duration="1.5s" data-wow-delay=".4s">
                    <div class="tab-pane big-image fade show active" id="gallery-img1">
                        <img alt="image" src="{{ asset('storage/' . $lot->lotable->mediaAttachments[0]?->file_path) }}"
                             class="img-fluid">
                    </div>
                    <div class="tab-pane big-image fade" id="gallery-img2">
                        <div class="auction-gallery-timer d-flex align-items-center justify-content-center">
                            <h3 id="countdown-timer-2">&nbsp;</h3>
                        </div>
                        <img alt="image" src="{{ asset('auction/assets/images/bg/prod-gallery2.png') }}"
                             class="img-fluid">
                    </div>
                    <div class="tab-pane big-image fade" id="gallery-img3">
                        <div class="auction-gallery-timer d-flex align-items-center justify-content-center">
                            <h3 id="countdown-timer-3">&nbsp;</h3>
                        </div>
                        <img alt="image" src="{{ asset('auction/assets/images/bg/prod-gallery3.png') }}"
                             class="img-fluid">
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-lg-5">
                <div class="product-details-right  wow fadeInDown" data-wow-duration="1.5s" data-wow-delay=".2s">
                    <h3>{{ $lot->lotable->name }}</h3>

                    <div class="lot-item-wrapper">
                        <div class="lot-item-row">
                            <div class="lot-item">
                                <p class="lot-item-label">Ариза қабул қилиш тугаш вақти: </p>
                                <p class="lot-item-text">{{ $lot->apply_deadline }}</p>
                            </div>
                            <div class="lot-item">
                                <p class="lot-item-label">Аукцион бошланиш вақти: </p>
                                <p class="lot-item-text">{{ $lot->starts_at }}</p>
                            </div>
                        </div>
                        <div class="lot-item-row">
                            <div class="lot-item">
                                <p class="lot-item-label">Бошланиш нархи (сўм): </p>
                                <p class="lot-item-text">{{ $lot->starting_price }}</p>
                            </div>
                            <div class="lot-item">
                                <p class="lot-item-label">Закалат пули фоизда: </p>
                                <p class="lot-item-text">{{ $lot->deposit_amount }}</p>
                            </div>
                        </div>
                        <div class="lot-item-row">
                            <div class="lot-item">
                                <p class="lot-item-label">Аукцион тури: </p>
                                <p class="lot-item-text">{{ $lot->type->getLabel() }}</p>
                            </div>
                        </div>
                    </div>

                    @if($lot->starts_at > now())
                        <div class="lot-item-block">
                            <h5>Аукцион бошлагунча: <span id="start_time">---</span></h5>
                        </div>
                    @elseif($lot->ends_at > now())
                        <div class="lot-item-block">
                            <h5>Аукцион бошланди! Тугагунча: <span id="ends_time">---</span></h5>
                        </div>
                    @else
                        <div class="lot-item-block">
                            <h5>Аукцион тугади</h5>
                        </div>
                    @endif

                    @if ($isLotApplyExpired)
                        <div class="lot-item-block">
                            <h5>Ариза қабул қилиш муддати ўтган</h5>
                        </div>
                    @elseif ($isLotApplied)
                        <div class="lot-item-block">
                            <h4 class="lot-block-title">Иштирок этиш учун</h4>
                            <p>Для подачи заявки на этот лот, нажмите кнопку ниже</p>
                            <a
                                href="{{ route('lot.apply', $lot->id) }}"
                                class="eg-btn btn--primary btn--sm"
                                type="submit"
                                wire:navigate
                            >Заявка бериш</a>
                        </div>
                    @else
                        <div class="lot-item-block">
                            <h5>Сиз ушбу лот учун ариза бергансиз.</h5>
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div>
</div>

@script

<script>

    // liviwire initialization event
    // TODO: events of livewire doesn't work
    document.addEventListener("DOMContentLoaded", () => {
        Livewire.hook('component.initialized', (component) => {console.log('component.initialized')})
        Livewire.hook('element.initialized', (el, component) => {console.log('element.initialized')})
        Livewire.hook('element.updating', (fromEl, toEl, component) => {console.log('element.updating')})
        Livewire.hook('element.updated', (el, component) => {console.log('element.updated')})
        Livewire.hook('element.removed', (el, component) => {console.log('element.removed')})
        Livewire.hook('message.sent', (message, component) => {console.log('message.sent')})
        Livewire.hook('message.failed', (message, component) => {console.log('message.failed')})
        Livewire.hook('message.received', (message, component) => {console.log('message.received')})
        Livewire.hook('message.processed', (message, component) => {console.log('message.processed')})
    });

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

    console.log(distanceToStart, distanceToEnd)

    if (distanceToStart > 1000) {
        const x = setInterval(function () {
            const now = new Date().getTime();
            const distance = startTime - now;
            document.getElementById("start_time").innerHTML = getDateLeft(distance);
            if (distance < 1000) {
                distanceToStart = 0;
                // refresh page with wire:navigate
                window.location.reload();
                clearInterval(x);
            }
        }, 1000);
    } else {
        if (distanceToEnd > 1000) {
            const x = setInterval(function () {
                const now = new Date().getTime();
                const distance = endsTime - now;
                document.getElementById("ends_time").innerHTML = getDateLeft(distance);
                if (distance < 100) {
                    distanceToEnd = 0;
                    window.location.reload();
                    clearInterval(x);
                }
            }, 1000);
        }
    }

</script>

@endscript
