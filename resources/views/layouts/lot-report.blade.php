@php
    /** @var App\Models\Lot $lot */
@endphp

    <!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        ul {
            list-style: none;
        }

        h3 {
            font-size: 18px;
        }

        td {
            padding-bottom: 10px;
            font-size: 14px;
            max-width: 400px;
        }

        p {
            font-size: 12px;
        }

        .bold {
            font-weight: bold;
            padding-right: 10px;
        }
    </style>
</head>
<body>

<div style="text-align: center" class="table-title-area d-flex justify-content-center flex-column mt-5 text-center">
    <h3>"E-AUKSIONSAVDO" платформасида бўлиб ўтган электрон-онлайн
        аукцион натижалари тўғрисид</h3>
    <p class="para mt-3" style="font-weight: bold; font-size: 12px;">БАЁННОМА № {{ $lot->number }}</p>
</div>

<div class="row">
    <div class="product-details-right col-12">
        <table class="d-flex flex-column gap-3">
            <tr class="d-flex align-content-center gap-3 w-100">
                <td class="bold w-50 text-danger"> Баённома расмийлаштирилган сана:</td>
                <td class="w-50">{{ $lot->reports_at?->format('d-M-Y') }} йил</td>
            </tr>
            <tr class="d-flex align-content-center gap-3 w-100">
                <td class="bold w-50 text-danger"> Электрон аукцион ўтказилган сана:</td>
                <td class="w-50">{{ $lot->starts_at->format('d-M-Y') }} йил</td>
            </tr>
            <tr class="d-flex align-content-center gap-3 w-100">
                <td class="bold w-50 text-danger"> Лот рақами ва автотранспорт тури:</td>
                <td class="w-50">Лот
                    № {{ $lot->number }} {{ $lot->lotable->categories->map(fn($category) => $category->title)->implode(', ') }}</td>
            </tr>
            <tr class="d-flex align-content-center gap-3 w-100">
                <td class="bold w-50 text-danger">Сотувчи маълумотлари:</td>
                <td class="w-50">{{ $lot->lotable->owner }}</td>
            </tr>
            <tr class="d-flex align-content-center gap-3 w-100">
                <td class="bold w-50 text-danger">Автотранспортни онлайн аукционга қўйиш бўйича тузилган шартнома:</td>
                <td class="w-50">{{ $lot->lotable->contract }}</td>
            </tr>
            <tr class="d-flex align-content-center gap-3 w-100">
                <td class="bold w-50 text-danger"> Автотранспортнинг номи:</td>
                <td class="w-50">{{ $lot->lotable->name }}</td>
            </tr>
            <tr class="d-flex align-content-center gap-3 w-100">
                <td class="bold w-50 text-danger"> Автотранспортни тавсифловчи маълумотлар:</td>
                <td class="w-50">
                    Модели №: {{ $lot->lotable->model }} <br>
                    Давлат раками №: {{ $lot->lotable->car_number }} <br>
                    Ишлаб чиқарилган йили: {{ $lot->lotable->year_of_issue }}. <br>
                    Ранги: {{ $lot->lotable->color }} <br>
                    Техник ҳолати: {{ $lot->lotable->technical_condition }}. <br>
                </td>
            </tr>
            <tr class="d-flex align-content-center gap-3 w-100">
                <td class="bold w-50 text-danger">Автотранспорт жойлашган ёки сақланаётган манзил:</td>
                <td class="w-50">{{ $lot->lotable->address }}</td>
            </tr>
            <tr class="d-flex align-content-center gap-3 w-100">
                <td class="bold w-50 text-danger">
                    Аукцион ғолиби (жисмоний шахснинг ФИШ,
                    паспорт маълумотлари серия ва рақами, қачон
                    ва ким томонидан берилган, юридик шахснинг
                    номи ва СТИРи):
                </td>
                <td class="w-50">
                    {{ $lot->winner?->user?->name }}, {{ $lot->winner?->user?->passport }}
                    {{ $lot->winner?->user?->passport_given }} томонидан
                    {{ $lot->winner?->user?->passport_date }} санасида берилган.
                    ЖШШИР: {{ $lot->winner?->user?->stir }}
                </td>
            </tr>
            <tr class="d-flex align-content-center gap-3 w-100">
                <td class="bold w-50 text-danger">Автотранспортнинг бошланғич баҳоси:</td>
                <td class="w-50">{{ number_format($lot->starting_price, 2) }} сўм</td>
            </tr>
            <tr class="d-flex align-content-center gap-3 w-100">
                <td class="bold w-50 text-danger">Автотранспортнинг сотилган баҳоси:</td>
                <td class="w-50">{{ number_format($lot->winner?->lastStep?->price, 2) }} сўм</td>
            </tr>
            <tr class="d-flex align-content-center gap-3 w-100">
                <td class="bold w-50 text-danger">Иштирокчилар</td>
                <td class="w-50">{{ $lot->winner?->user?->name }}</td>
            </tr>
        </table>
    </div>
</div>

<div class="table-title-area d-flex justify-content-center flex-column mt-5">
    <p class="para">
        Ўзбекистон Республикаси Фуқаролик Кодексининг 380-моддасига асосан
        “Etrading.uz” платформасида электрон онлайн-аукцион ташкил этиш ҳамда
        ўтказиш натижасида вужудга келган мазкур баённома шартнома кучига эга.
    </p>
</div>

<div class="row">
    <table class="col-9 product-details-right">
        <tr>
            <td style="min-width: 200px; margin-right: 20px">
                @php
                    $appUrl = config('app.url') . '/lot-report/' . $lot->id;
                    $qrCode = (new chillerlan\QRCode\QRCode)->render($appUrl);
                @endphp
                <img
                    width="300"
                    height="300"
                    src="{{ $qrCode }}"
                    alt="qr-code"
                />
            </td>
            <td>
                <p>
                    Баённомада кўрсатилган маълумотлар тўғрилигини текшириш учун
                    мобил телефон ёрдамида QR-кодни сканер қилинг. Хужжат
                    нусхасидаги маълумотнинг мутаносиблиги унинг ҳақиқийлигини
                    тасдиқлайди. Акс ҳолатда хужжатнинг нусхасидаги мос бўлмаган
                    маълумот сохталаштирилган/таҳрирланган, деб баҳоланиши
                    асослидир
                </p>
            </td>
        </tr>
    </table>
</div>

</body>
</html>
