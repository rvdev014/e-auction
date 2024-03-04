<div class="signup-section pt-120 pb-120">
    <img alt="image" src="{{ asset('auction/assets/images/bg/section-bg.png') }}" class="section-bg-top">
    <img alt="image" src="{{ asset('auction/assets/images/bg/section-bg.png') }}" class="section-bg-bottom">
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-xl-6 col-lg-8 col-md-10">
                <div class="form-wrapper wow fadeInUp" data-wow-duration="1.5s" data-wow-delay=".2s">
                    <div class="form-title">
                        <h3>Телефон рақамингизни тасдиқлаш</h3>
                        <p>Ракамингизга смс-код жўнатилди. Илтимос, смс-кодни киритинг.</p>
                        <p>Агар смс-код келмаса, <a href="javascript:void(0)" wire:click="resend">Янги кодни жўнатиш</a></p>
                    </div>

                    @include('includes.alerts')

                    <form method="post" class="w-100" wire:submit="submitForm">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-inner">
                                    <label for="verification_code">СМС-код</label>
                                    <input
                                        wire:model="verification_code"
                                        type="text"
                                        id="verification_code"
                                        name="verification_code"
                                        placeholder="СМС-код"
                                    >
                                    @error('verification_code') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                        <button
                            class="account-btn"
                            wire.loading.attr="disabled"
                        >
                            Тасдиқлаш
                        </button>
                        <p wire:loading>Loading....</p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
