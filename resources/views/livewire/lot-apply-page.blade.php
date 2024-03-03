<div class="auction-details-section container">
    <img alt="image" src="{{ asset('auction/assets/images/bg/section-bg.png') }}" class="img-fluid section-bg-top">
    <img alt="image" src="{{ asset('auction/assets/images/bg/section-bg.png') }}" class="img-fluid section-bg-bottom">

    <div class="lot-public-offer">
        <a href="{{ route('lot.details', $lot->id) }}" style="display: block;margin-bottom: 20px">< Орқага</a>
        <p>“E-AUKSION” электрон савдо платформасида электрон онлайн-аукционлар ва электрон танловларни ташкил этиш ва ўтказиш хизматларини кўрсатиш бўйича</p>

        <h4>Оммавий оферта</h4>
        <p>
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci alias aliquid amet, animi
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci alias aliquid amet, animi
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci alias aliquid amet, animi
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci alias aliquid amet, animi
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci alias aliquid amet, animi
        </p>
        <p>
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci alias aliquid amet, animi
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci alias aliquid amet, animi
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci alias aliquid amet, animi
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci alias aliquid amet, animi
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci alias aliquid amet, animi
        </p>
        <p>
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci alias aliquid amet, animi
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci alias aliquid amet, animi
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci alias aliquid amet, animi
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci alias aliquid amet, animi
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci alias aliquid amet, animi
        </p>
        <div class="d-flex">
            <input required class="form-check" type="checkbox" wire:model.live="isApproved" id="flexCheckDefault">
            <label for="flexCheckDefault" style="margin-left: 10px">
                Мен қошимча шартларни қабул қиламан
            </label>
            @error('isApproved') <span class="error">{{ $message }}</span> @enderror
        </div>
        <button
            class="eg-btn btn--primary btn--sm"
            wire:click="onApply"
            style="margin-top: 20px"
            @if(!$isApproved) disabled @endif
        >
            Заявка бериш
        </button>
    </div>
</div>
