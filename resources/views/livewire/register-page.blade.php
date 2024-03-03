<div class="signup-section pt-120 pb-120">
    <img alt="image" src="{{ asset('auction/assets/images/bg/section-bg.png') }}" class="section-bg-top">
    <img alt="image" src="{{ asset('auction/assets/images/bg/section-bg.png') }}" class="section-bg-bottom">
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-xl-6 col-lg-8 col-md-10">
                <div class="form-wrapper wow fadeInUp" data-wow-duration="1.5s" data-wow-delay=".2s">
                    <div class="form-title">
                        <h3>Рўйхатдан ўтинг</h3>
                        <p>Сизда аллақачон аккаунт борми? <a href="{{ route('login') }}" wire:navigate>Бу ерда кириш</a></p>
                    </div>

                    <form method="post" class="w-100" wire:submit="submitForm">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-inner">
                                    <label for="phone">Телефон рақам</label>
                                    <input
                                        id="phone"
                                        wire:model="phone"
                                        type="text"
                                        name="phone"
                                        placeholder="Телефон рақам"
                                    />
                                    @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-inner">
                                    <label for="password">Парол</label>
                                    <input
                                        id="password"
                                        wire:model="password"
                                        type="password"
                                        name="password"
                                        placeholder="Парол"
                                    />
                                    @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-inner">
                                    <label for="password_confirmation">Паролни такрорлаш</label>
                                    <input
                                        id="password_confirmation"
                                        wire:model="password_confirmation"
                                        type="password"
                                        name="password_confirmation"
                                        placeholder="Паролни такрорлаш"
                                    />
                                    @error('password_confirmation') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>

                        </div>
                        <button class="account-btn">
                            Аккаунт яратиш
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
