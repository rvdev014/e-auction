@php
    /** @var App\Models\Lot $lot */
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
        <h3>"E-TRADINGSAVDO" платформасида бўлиб ўтган электрон-онлайн
            аукцион натижалари тўғрисид</h3>
        <p class="para mt-3">БАЁННОМА № {{ $lot->number }}</p>
    </div>

    <div class="row">
        <div class="product-details-right col-12" >
            <ul class="d-flex flex-column gap-3">
                <li class="d-flex align-content-center gap-3 w-100">
                    <h4 class="w-50 text-bold"> Баённома расмийлаштирилган сана:</h4>
                    <h4 class="w-50">{{ $lot->reports_at?->format('d-M-Y') }} йил</h4>
                </li>
                <li class="d-flex align-content-center gap-3 w-100">
                    <h4 class="w-50 text-bold">Электрон аукцион ўтказилган сана:</h4>
                    <h4 class="w-50">{{ $lot->starts_at->format('d-M-Y') }} йил</h4>
                </li>
                <li class="d-flex align-content-center gap-3 w-100">
                    <h4 class="w-50 text-bold"> Лот рақами ва автотранспорт тури:</h4>
                    <h4 class="w-50">Лот № {{ $lot->number }} {{ $lot->lotable->categories->map(fn($category) => $category->title)->implode(', ') }}</h4>
                </li>
                <li class="d-flex align-content-center gap-3 w-100">
                    <h4 class="w-50 text-bold"> Сотувчи маълумотлари:</h4>
                    <h4 class="w-50">{{ $lot->lotable->owner }}</h4>
                </li>
                <li class="d-flex align-content-center gap-3 w-100">
                    <h4 class="w-50 text-bold">Автотранспортни онлайн аукционга қўйиш бўйича тузилган шартнома:</h4>
                    <h4 class="w-50">{{ $lot->lotable->contract }}</h4>
                </li>
                <li class="d-flex align-content-center gap-3 w-100">
                    <h4 class="w-50 text-bold">Автотранспортнинг номи:</h4>
                    <h4 class="w-50">{{ $lot->lotable->name }}</h4>
                </li>
                <li class="d-flex align-content-center gap-3 w-100">
                    <h4 class="w-50 text-bold">Автотранспортни тавсифловчи маълумотлар:</h4>
                    <h4 class="w-50">
                        Модели №: {{ $lot->lotable->model }} <br>
                        Давлат раками №: {{ $lot->lotable->car_number }} <br>
                        Ишлаб чиқарилган йили: {{ $lot->lotable->year_of_issue }}. <br>
                        Ранги: {{ $lot->lotable->color }} <br>
                        Техник ҳолати: {{ $lot->lotable->technical_condition }}. <br>
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
                        {{ $lot->winner?->user?->name }}, {{ $lot->winner?->user?->passport }}
                        {{ $lot->winner?->user?->passport_given }} томонидан
                        {{ $lot->winner?->user?->passport_date }} санасида берилган.
                        ЖШШИР: {{ $lot->winner?->user?->stir }}
                    </h4>
                </li>
                <li class="d-flex align-content-center gap-3 w-100">
                    <h4 class="w-50 text-bold">Автотранспортнинг бошланғич баҳоси:</h4>
                    <h4 class="w-50">{{ number_format($lot->starting_price, 2) }} сўм</h4>
                </li>
                <li class="d-flex align-content-center gap-3 w-100">
                    <h4 class="w-50 text-bold"> Автотранспортнинг сотилган баҳоси:</h4>
                    <h4 class="w-50">{{ number_format($lot->winner?->lastStep?->price, 2) }} сўм</h4>
                </li>
                <li class="d-flex align-content-center gap-3 w-100">
                    <h4 class="w-50 text-bold">Иштирокчилар:</h4>
                    <h4 class="w-50">{{ $lot->winner?->user?->name }}</h4>
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
    <a href="{{ route('lot.report.pdf', $lot->id) }}" class="btn--lg btn--primary">PDF юклаб олиш</a>
</div>

@include('includes.footer')

</body>
</html>
