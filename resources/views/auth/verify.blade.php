@extends('layout.auth')
@section('title', 'Рўйхатдан ўтиш')
@section('content')
    <div class="signup-section pt-120 pb-120">
        <img alt="image" src="{{ asset('auction/assets/images/bg/section-bg.png') }}" class="section-bg-top">
        <img alt="image" src="{{ asset('auction/assets/images/bg/section-bg.png') }}" class="section-bg-bottom">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-xl-6 col-lg-8 col-md-10">
                    <div class="form-wrapper wow fadeInUp" data-wow-duration="1.5s" data-wow-delay=".2s">
                        <div class="form-title">
                            <h3>СМС-код ни киритинг</h3>
                        </div>

                        @include('blocks.error')

                        <form method="post" class="w-100">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-inner">
                                        <label>СМС-код</label>
                                        <input type="text" name="verification_code" placeholder="СМС-код">
                                    </div>
                                </div>
                            </div>
                            <button class="account-btn">
                                Тасдиқлаш
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
