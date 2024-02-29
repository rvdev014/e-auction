@extends('layout.auth')
@section('title', 'Тизимга кириш')
@section('content')
    <div class="signup-section pt-120 pb-120">
        <img alt="image" src="{{ asset('auction/assets/images/bg/section-bg.png') }}" class="section-bg-top">
        <img alt="image" src="{{ asset('auction/assets/images/bg/section-bg.png') }}" class="section-bg-bottom">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-xl-6 col-lg-8 col-md-10">
                    <div class="form-wrapper wow fadeInUp" data-wow-duration="1.5s" data-wow-delay=".2s">
                        <div class="form-title">
                            <h3>Тизимга кириш</h3>
                            <p>Аккаунтингиз мавжуд эмас ми? <a href="{{ route('register') }}">Рўйхатдан ўтиш</a></p>
                        </div>
                        <form method="post" class="w-100">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-inner">
                                        <label>Телефон рақам</label>
                                        <input type="email" placeholder="Телефон рақам">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-inner">
                                        <label>Парол</label>
                                        <input type="email" placeholder="Парол">
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

@endsection
