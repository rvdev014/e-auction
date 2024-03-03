<div class="signup-section pt-120 pb-120">
    <img alt="image" src="{{ asset('auction/assets/images/bg/section-bg.png') }}" class="section-bg-top">
    <img alt="image" src="{{ asset('auction/assets/images/bg/section-bg.png') }}" class="section-bg-bottom">
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-xl-6 col-lg-8 col-md-10">
                <div class="form-wrapper wow fadeInUp" data-wow-duration="1.5s" data-wow-delay=".2s">
                    <div class="form-title">
                        <h3>Тизимга кириш</h3>
                        <p>Аккаунтингиз мавжуд эмас ми? <a href="{{ route('register') }}" wire:navigate>Рўйхатдан ўтиш</a></p>
                    </div>

                    <form method="post" class="w-100" wire:submit="submitForm">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-inner">
                                    <label>Телефон рақам</label>
                                    <input wire:model="phone" type="text" name="phone" placeholder="Телефон рақам">
                                    @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-inner">
                                    <label>Парол</label>
                                    <input wire:model="password" type="password" name="password" placeholder="Парол">
                                    @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>

                        </div>
                        <button class="account-btn">
                            Тизимга кириш
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
