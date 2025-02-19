@php
    use App\Services\PaymentService;
    /** @var App\Models\LotWinningReport $winningReport */
    /** @var App\Models\Lot $lot */

$lot = $winningReport->lot;
@endphp

        <!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('auction-app/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('auction-app/assets/css/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('auction-app/assets/css/style.css') }}">
    <style>
        ul {
            padding: 0;
        }
    </style>
</head>
<body>
@include('includes.nav')
<div class="container" style="padding: 0 20px">
    <div class="table-title-area d-flex justify-content-center flex-column mt-5 text-center">
        <h3>
            "E-TRADING" платформасида бўлиб ўтган электрон-онлайн
            аукцион натижалари тўғрисидаги
        </h3>
        <p class="para mt-3">ҒОЛИБЛИК БАЁННОМАСИ №{{ $winningReport->id }}</p>
    </div>

    <div class="row">
        <div class="product-details-right col-12">
            <ul class="d-flex flex-column gap-3">
                <li class="d-flex align-content-center gap-3 w-100">
                    <h4 class="w-50 text-bold">Электрон аукцион ўтказилган сана:</h4>
                    <h4 class="w-50">{{ $lot->starts_at->format('d-M-Y') }} йил</h4>
                </li>
                <li class="d-flex align-content-center gap-3 w-100">
                    <h4 class="w-50 text-bold">Баённома расмийлаштирилган сана:</h4>
                    <h4 class="w-50">{{ $lot->reports_at?->format('d-M-Y') }} йил</h4>
                </li>
                <li class="d-flex align-content-center gap-3 w-100">
                    <h4 class="w-50 text-bold">Лот рақами ва автотранспорт тури:</h4>
                    <h4 class="w-50">Лот
                        №{{ $lot->number }}
                        , {{ $lot->lotable->categories->map(fn($category) => $category->title)->implode(', ') }}</h4>
                </li>
                <li class="d-flex align-content-center gap-3 w-100">
                    <h4 class="w-50 text-bold">Сотувчи маълумотлари:</h4>
                    <h4 class="w-50">{{ $lot->lotable->owner }}</h4>
                </li>
                <li class="d-flex align-content-center gap-3 w-100">
                    <h4 class="w-50 text-bold">Автотранспортни онлайн аукционга қўйиш учун асос:</h4>
                    <h4 class="w-50">
                        "Chinobod neft bazasi" MCHJning  2024 yil 2 dekabrdagi 17-410-sonli buyurtmanomasi
                    </h4>
{{--                    <h4 class="w-50">{{ $lot->lotable->contract }}</h4>--}}
                </li>
                <li class="d-flex align-content-center gap-3 w-100">
                    <h4 class="w-50 text-bold">Автотранспортнинг номи:</h4>
                    <h4 class="w-50">{{ $lot->lotable->name }}</h4>
                </li>
                <li class="d-flex align-content-center gap-3 w-100">
                    <h4 class="w-50 text-bold">Автотранспортни тавсифловчи маълумотлар:</h4>
                    <h4 class="w-50">
{{--                        Модели: {{ $lot->lotable->model }} <br>--}}
                        Давлат раками №: {{ $lot->lotable->car_number }} <br>
                        Двигатель №: {{ $lot->lotable->engine_number }}. <br>
                        Кузов/Шасси рақами: {{ $lot->lotable->body_number }}. <br>
                        Ранги: {{ $lot->lotable->color }} <br>
                        Ишлаб чиқарилган йили: {{ $lot->lotable->year_of_issue }}. <br>
                        Техник ҳолати: {{ $lot->lotable->technical_condition }}. <br>
                        Гувохнома рақами: {{ $lot->lotable->contract }}. <br>
                    </h4>
                </li>
                <li class="d-flex align-content-center gap-3 w-100">
                    <h4 class="w-50 text-bold">Автотранспорт жойлашган ёки сақланаётган манзил:</h4>
                    <h4 class="w-50">{{ $lot->lotable->address }}</h4>
                </li>
                <li class="d-flex align-content-center gap-3 w-100">
                    <h4 class="w-50 text-bold">
                        Аукцион ғолиби (жисмоний шахснинг ФИШ,
                        паспорт маълумотлари серия ва рақами, қачон
                        ва ким томонидан берилган, юридик шахснинг
                        номи ва СТИРи):
                    </h4>
                    <h4 class="w-50">
                        @php
                            $content = $lot->winner?->user?->name ? $lot->winner->user->name . ",<br>" : "";
                            $content .= $lot->winner?->user?->lots_member_number ? "Фишка рақами №: " . $lot->winner->user->lots_member_number . ",<br>" : "";
                            $content .= $lot->winner?->user?->passport ? "Пасспорт: " . $lot->winner->user->passport . ",<br>" : "";
                            $content .= $lot->winner?->user?->passport_given ? $lot->winner->user->passport_given . " томонидан " : "";
                            $content .= $lot->winner?->user?->passport_date ? $lot->winner->user->passport_date->format('d.m.Y') . " санасида берилган" . ",<br>" : "";
                            $content .= $lot->winner?->user?->stir ? "ЖШШИР: " . $lot->winner->user->stir . "<br>" : "";

                            echo $content;
                        @endphp
                    </h4>
                </li>
                <li class="d-flex align-content-center gap-3 w-100">
                    <h4 class="w-50 text-bold">Автотранспортнинг бошланғич баҳоси:</h4>
                    <h4 class="w-50">
                        {{ number_format($lot->starting_price, 2) }} сўм
                        ({{ PaymentService::numberToUzbekText($lot->starting_price) }})
                    </h4>
                </li>
                <li class="d-flex align-content-center gap-3 w-100">
                    <h4 class="w-50 text-bold">Автотранспортнинг сотилган баҳоси:</h4>
                    <h4 class="w-50">
                        {{ number_format($lot->winner?->lastStep?->price, 2) }} сўм
                        ({{ PaymentService::numberToUzbekText($lot->winner?->lastStep?->price) }})
                    </h4>
                </li>
                <li class="d-flex align-content-center gap-3 w-100">
                    <h4 class="w-50 text-bold">Иштирокчилар фишка рақами:</h4>
                    <h4 class="w-50">
                        @php
                            $users = $lot->users->map(fn($user) => "$user->lots_member_number");
                            echo implode(', ', $users->toArray());
                        @endphp
                    </h4>
                </li>
            </ul>
        </div>
    </div>

    <div class="table-title-area d-flex justify-content-center flex-column mt-5">
        <p class="para ">
            Ўзбекистон Республикаси Фуқаролик Кодексининг 380-моддасига асосан
            “Etrading.uz” платформасида электрон онлайн-аукцион ташкил этиш ҳамда
            ўтказиш натижасида вужудга келган мазкур баённома шартнома кучига эга.
        </p>
    </div>

    <div class="row" style="padding-bottom: 80px;">
        <div class="col-3 d-flex justify-content-center align-items-center">
            <div class="qr-code">
                @php
                    $appUrl = config('app.url') . '/lot-report/' . $lot->id;
                    $qrCode = (new chillerlan\QRCode\QRCode)->render($appUrl);
                @endphp
                <img
                        width="150"
                        height="150"
                        src="{{ $qrCode }}"
                        alt="qr-code"
                />
            </div>
        </div>
        <div class="col-9 product-details-right">
            <p>
                Баённомада кўрсатилган маълумотлар тўғрилигини текшириш учун
                мобил телефон ёрдамида QR-кодни сканер қилинг. Хужжат
                нусхасидаги маълумотнинг мутаносиблиги унинг ҳақиқийлигини
                тасдиқлайди. Акс ҳолатда хужжатнинг нусхасидаги мос бўлмаган
                маълумот сохталаштирилган/таҳрирланган, деб баҳоланиши
                асослидир
            </p>
        </div>
    </div>
</div>

<div class="d-flex justify-content-center py-5">
    <a href="{{ route('lot.report.pdf', $winningReport->id) }}" class="btn--lg btn--primary">PDF юклаб олиш</a>
</div>

@include('includes.footer')

</body>
</html>
