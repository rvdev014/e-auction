@php
    use App\Enums\LotStatus;

    /** @var App\Models\Lot $lot */
    $images = $lot->lotable->mediaAttachments;
    $isLotActive = !$lot->is_cancelled && $lot->ends_at > now();
    $isLotStarted = $lot->starts_at < now() && $lot->ends_at > now();
    $isLotApplied = $this->lot->steps()->where('user_id', auth()->user()->id)->exists();
    $isLotApplyExpired = $lot->apply_deadline < now();
@endphp

<div>
    @include('livewire.components.breadcrumb', ['title' => 'Аукцион сахифаси'])

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
                            @if (!$lot->lotable->mediaAttachments->isEmpty())
                                <img
                                    alt="image"
                                    src="{{ asset('storage/' . $lot->lotable->mediaAttachments[0]?->file_path) }}"
                                    class="img-fluid"
                                >
                            @endif
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

                        <div class="bid-form" style="margin-top: 0">
                            <div class="form-title" style="margin-bottom: 20px">
                                <h3>{{ $lot->lotable->name }}</h3>
                            </div>

                            <div class="lot-item-wrapper">
                                <div class="lot-item">
                                    <p class="lot-item-label">Ариза қабул қилиш тугаш вақти: </p>
                                    <p class="lot-item-text">{{ $lot->apply_deadline->format('d-M H:i') }}</p>
                                </div>
                                <div class="lot-item">
                                    <p class="lot-item-label">Аукцион бошланиш вақти: </p>
                                    <p class="lot-item-text">{{ $lot->starts_at->format('d-M H:i') }}</p>
                                </div>
                                <div class="lot-item">
                                    <p class="lot-item-label">Аукцион тугаш вақти: </p>
                                    <p class="lot-item-text">{{ $lot->ends_at->format('d-M H:i') }}</p>
                                </div>
                                <div class="lot-item">
                                    <p class="lot-item-label">Бошланиш нархи: </p>
                                    <p class="lot-item-text">{{ $lot->starting_price }} сўм</p>
                                </div>
                                <div class="lot-item">
                                    <p class="lot-item-label">Закалат пули фоизда: </p>
                                    <p class="lot-item-text">{{ $lot->deposit_amount }}</p>
                                </div>
                                <div class="lot-item">
                                    <p class="lot-item-label">Аукцион тури: </p>
                                    <p class="lot-item-text">{{ $lot->type->getLabel() }}</p>
                                </div>
                                <div class="lot-item">
                                    <p class="lot-item-label">Аукцион холати: </p>
                                    <p class="lot-item-text">
                                        @if($lot->is_cancelled)
                                            <span class="text-danger">{{ LotStatus::Cancelled->getLabel() }}</span>
                                        @elseif ($lot->ends_at->isPast())
                                            <span>{{ LotStatus::Ended->getLabel() }}</span>
                                        @else
                                            <span class="text-success">{{ LotStatus::Active->getLabel() }}</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>

                        @include('livewire.components.lot-timer', ['lot' => $lot])

                        @if ($isLotActive)
                            @if ($isLotStarted && $isLotApplied)
                                <div class="bid-form">
                                    <div class="form-title">
                                        <h5>Аукционда иштирок этиш</h5>
                                        <p>Кадам нархи (сўм): Минимум {{ $this->maxPrice }} сўм</p>
                                    </div>
                                    <form wire:submit="onStep">
                                        <div class="form-inner gap-2">
                                            <div class="lot-step-input">
                                                <input type="text" name="step" placeholder="00.00" wire:model="step">
                                                @error('step') <span class="error">{{ $message }}</span> @enderror
                                            </div>
                                            <button class="eg-btn btn--primary btn--sm">Кадам қўйиш</button>
                                        </div>
                                    </form>
                                </div>
                            @elseif ($isLotApplyExpired)
                                <div class="bid-form">
                                    <div class="form-title">
                                        <h5>Ариза қабул қилиш муддати ўтган</h5>
                                    </div>
                                </div>
                            @elseif ($isLotApplied)
                                <div class="bid-form">
                                    <div class="form-title">
                                        <h5>Сиз ушбу лот учун ариза бергансиз</h5>
                                    </div>
                                </div>
                            @elseif ($lot->starts_at > now())
                                <div class="bid-form">
                                    <div class="form-title">
                                        <h5>Иштирок этиш учун</h5>
                                        <p>Для подачи заявки на этот лот, нажмите кнопку ниже</p>
                                        <a
                                            href="{{ route('lot.apply', $lot->id) }}"
                                            class="eg-btn btn--primary btn--sm"
                                            style="margin-top: 20px"
                                            wire:navigate
                                        >Заявка бериш</a>
                                    </div>
                                </div>
                            @endif
                        @endif

                    </div>
                </div>
            </div>

            <div class="row d-flex justify-content-center g-4">
                <div class="col-lg-12">
                    <ul wire:ignore class="nav nav-pills d-flex flex-row justify-content-start gap-sm-4 gap-3 mb-45 wow fadeInDown" data-wow-duration="1.5s" data-wow-delay=".2s" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button
                                class="nav-link details-tab-btn {{ $this->tab === 'lot-info' ? 'active' : '' }}"
                                id="pills-home-tab"
                                data-bs-toggle="pill"
                                data-bs-target="#pills-home"
                                type="button"
                                role="tab"
                                aria-controls="pills-home"
                                aria-selected="true"
                                wire:click="setTab('lot-info')"
                            >Лот маълумотлари</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button
                                class="nav-link details-tab-btn {{ $this->tab === 'lot-steps' ? 'active' : '' }}"
                                id="pills-bid-tab"
                                data-bs-toggle="pill"
                                data-bs-target="#pills-bid"
                                type="button"
                                role="tab"
                                aria-controls="pills-bid"
                                aria-selected="false"
                                wire:click="setTab('lot-steps')"
                            >Ставкалар тарихи</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div wire:ignore class="tab-pane fade show @if($this->tab === 'lot-info') active @endif wow fadeInUp"  data-wow-duration="1.5s" data-wow-delay=".2s" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                            @include('livewire.components.lot-info-accordion', ['lot' => $lot])
                        </div>
                        <div class="tab-pane fade show @if($this->tab === 'lot-steps') active @endif wow fadeInUp" id="pills-bid" role="tabpanel" aria-labelledby="pills-bid-tab">
                            @include('livewire.components.lot-step-list', ['lot' => $lot])
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
