@php
@endphp

<div>
    @include('livewire.components.breadcrumb', ['title' => 'Контакт'])

    <div class="contact-section pt-120 pb-120">
        <img alt="image" src="{{ asset('auction-app/assets/images/bg/section-bg.png') }}" class="img-fluid section-bg-top">
        <img alt="image" src="{{ asset('auction-app/assets/images/bg/section-bg.png') }}" class="img-fluid section-bg-bottom">
        <div class="container">
            <div class="row pb-120 mb-70 g-4 d-flex justify-content-center ">
                <div class="col-lg-4 col-md-6 col-sm-8">
                    <div class="contact-signle hover-border1 d-flex flex-row align-items-center wow fadeInDown"
                         data-wow-duration="1.5s" data-wow-delay=".2s">
                        <div class="icon">
                            <i class="bi bi-geo-alt"></i>
                        </div>
                        <div class="text">
                            <h4>Манзил</h4>
                            <p>Тошкент шахар, Мирзо-Улуғбек тумани,
                                Паркент кўчаси, 51 -уй.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-8">
                    <div class="contact-signle hover-border1 d-flex flex-row align-items-center wow fadeInDown"
                         data-wow-duration="1.5s" data-wow-delay=".4s">
                        <div class="icon">
                            <i class='bx bx-phone-call'></i>
                        </div>
                        <div class="text">
                            <h4>Телефон</h4>
                            <a href="tel:+880171-770000">+998 (71) 236 25 53</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-8">
                    <div class="contact-signle hover-border1 d-flex flex-row align-items-center wow fadeInDown"
                         data-wow-duration="1.5s" data-wow-delay=".6s">
                        <div class="icon">
                            <i class='bx bx-envelope'></i>
                        </div>
                        <div class="text">
                            <h4>Email</h4>
                            <a href="mailto:info@example.com">info@e-auksionsavdo.uz</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="contact-signle hover-border1 d-flex flex-row align-items-center wow fadeInDown"
                         data-wow-duration="1.5s" data-wow-delay=".6s">
                        <div class="text">
                            <p href="mailto:info@example.com">h/r: 2020 8000 2070 1930 9001 AТB “HAMKOR BANK”, MFO
                                00083, </p>
                            <p>INN 311 133 105</p>
                            <a href="tel:+998946176140">Tel: (94) 617 63 40</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-lg-12">
                    <div class="form-wrapper wow fadeInDown" data-wow-duration="1.5s" data-wow-delay=".2s">
                        <form method="post" wire:submit="submitForm">
                            <div class="row">
                                <div class="col-xl-6 col-lg-12 col-md-6">
                                    <div class="form-inner">
                                        <input wire:model="name" type="text" name="name" placeholder="Исм">
                                        @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-12 col-md-6">
                                    <div class="form-inner">
                                        <input wire:model="email" type="text" name="email" placeholder="Электрон манзил">
                                        @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <textarea wire:model="subject" name="subject" placeholder="Мавзу" rows="12"></textarea>
                                    @error('subject') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="eg-btn btn--primary btn--md form--btn">Жўнатиш</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
