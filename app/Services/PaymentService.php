<?php

namespace App\Services;

use Throwable;
use App\Models\Lot;
use App\Models\LotUser;
use App\Models\LotUserStep;
use App\Enums\LotPaymentStatus;
use Illuminate\Support\Facades\DB;

class PaymentService
{
    public function __construct(
        private readonly LotService $lotService,
        private readonly SmsService $smsService
    ) {}

    public function checkUserPayments(): void
    {
        /** @var Lot[] $lots */
        $lots = Lot::query()
            ->where('payment_deadline', '<', now())
            ->where('payment_status', LotPaymentStatus::NotPaid)
            ->where('is_cancelled', false)
            ->get();

        foreach ($lots as $lot) {
            $oldWinner = $lot->winner;
            if (!$oldWinner) {
                continue;
            }

            DB::beginTransaction();

            try {
                $oldWinner->updateOrFail(['is_winner' => false]);

                /** @var LotUserStep $newWinnerStep */
                $newWinnerStep = $lot->steps()
                    ->where('price', '<', $oldWinner->lastStep->price)
                    ->whereRelation('lotUser', 'user_id', '!=', $oldWinner->user_id)
                    ->orderByDesc('price')
                    ->first();

                if ($newWinnerStep) {
                    $newLotUser = $newWinnerStep->lotUser;
                    $lot->updateOrFail([
                        'payment_deadline' => $this->lotService->getPaymentDeadline()
                    ]);
                    $newLotUser->updateOrFail(['is_winner' => true]);
                    $this->lotService->sendSmsToWinner($lot, $newLotUser);
                }

                $body = "#$lot->number рақамли лотнинг тўлаш муддати тугади. Лот бекор қилинди.";
                $oldWinner->user->messages()->create([
                    'title' => "#$lot->number рақамли лот бекор қилинди.",
                    'body' => $body
                ]);

                try {
                    $this->smsService->sendSms(
                        $oldWinner->user->phone,
                        <<<TEXT
$body

Батафсил: {$lot->getLink()}
TEXT
                    );
                } catch (Throwable $e) {
                    logger()->error($e->getMessage());
                }

                DB::commit();
            } catch (Throwable $e) {
                DB::rollBack();
                logger()->error($e->getMessage());
            }
        }
    }

    public static function underThousandToText($n): string
    {
        $ones = ["", "бир", "икки", "уч", "тўрт", "беш", "олти", "етти", "саккиз", "тўққиз"];
        $tens = ["", "ўн", "йигирма", "ўттиз", "қирқ", "эллик", "олтмиш", "етмиш", "саксон", "тўқсон"];
        $hundreds = ["", "юз", "икки юз", "уч юз", "тўрт юз", "беш юз", "олти юз", "йетти юз", "саккиз юз", "тўққиз юз"];
        $thousands = ["", "минг", "икки минг", "уч минг", "тўрт минг", "беш минг", "олти минг", "етти минг", "саккиз минг", "тўққиз минг"];
        $tenThousands = ["", "ўн минг", "йигирма минг", "ўттиз минг", "қирқ минг", "эллик минг", "олтмиш минг", "етмиш минг", "саксон минг", "тўқсон минг"];
        $hundredThousands = ["", "юз минг", "икки юз минг", "уч юз минг", "тўрт юз минг", "беш юз минг", "олти юз минг", "йетти юз минг", "саккиз юз минг", "тўққиз юз минг"];
        $millions = ["", "миллион", "икки миллион", "уч миллион", "тўрт миллион", "беш миллион", "олти миллион", "етти миллион", "саккиз миллион", "тўққиз миллион"];
        $tenMillions = ["", "ўн миллион", "йигирма миллион", "ўттиз миллион", "қирқ миллион", "эллик миллион", "олтмиш миллион", "етмиш миллион", "саксон миллион", "тўқсон миллион"];
        $hundredMillions = ["", "юз миллион", "икки юз миллион", "уч юз миллион", "тўрт юз миллион", "беш юз миллион", "олти юз миллион", "йетти юз миллион", "саккиз юз миллион", "тўққиз юз миллион"];
        $billions = ["", "миллиард", "икки миллиард", "уч миллиард", "тўрт миллиард", "беш миллиард", "олти миллиард", "етти миллиард", "саккиз миллиард", "тўққиз миллиард"];
        $tenBillions = ["", "ўн миллиард", "йигирма миллиард", "ўттиз миллиард", "қирқ миллиард", "эллик миллиард", "олтмиш миллиард", "етмиш миллиард", "саксон миллиард", "тўқсон миллиард"];
        $hundredBillions = ["", "юз миллиард", "икки юз миллиард", "уч юз миллиард", "тўрт юз миллиард", "беш юз миллиард", "олти юз миллиард", "йетти юз миллиард", "саккиз юз миллиард", "тўққиз юз миллиард"];
        $hundreds = ["", "юз", "икки юз", "уч юз", "тўрт юз", "беш юз", "олти юз", "етти юз", "саккиз юз", "тўққиз юз"];

        if ($n == 0) {
            return "";
        } elseif ($n < 10) {
            return $ones[$n];
        } elseif ($n < 100) {
            return $tens[floor($n / 10)] . ($n % 10 != 0 ? " " . $ones[$n % 10] : "");
        } elseif ($n < 1000) {
            return $hundreds[floor($n / 100)] . ($n % 100 >= 10 ? " " . $tens[floor(($n % 100) / 10)] : "") . ($n % 10 != 0 ? " " . $ones[$n % 10] : "");
        } elseif ($n < 10000) {
            return $thousands[floor($n / 1000)] . ($n % 1000 != 0 ? " " . self::underThousandToText($n % 1000) : "");
        } elseif ($n < 100000) {
            return $tenThousands[floor($n / 10000)] . ($n % 10000 != 0 ? " " . self::underThousandToText($n % 10000) : "");
        } elseif ($n < 1000000) {
            return $hundredThousands[floor($n / 100000)] . ($n % 100000 != 0 ? " " . self::underThousandToText($n % 100000) : "");
        } elseif ($n < 10000000) {
            return $millions[floor($n / 1000000)] . ($n % 1000000 != 0 ? " " . self::underThousandToText($n % 1000000) : "");
        } elseif ($n < 100000000) {
            return $tenMillions[floor($n / 10000000)] . ($n % 10000000 != 0 ? " " . self::underThousandToText($n % 10000000) : "");
        } elseif ($n < 1000000000) {
            return $hundredMillions[floor($n / 100000000)] . ($n % 100000000 != 0 ? " " . self::underThousandToText($n % 100000000) : "");
        } elseif ($n < 10000000000) {
            return $billions[floor($n / 1000000000)] . ($n % 1000000000 != 0 ? " " . self::underThousandToText($n % 1000000000) : "");
        } elseif ($n < 100000000000) {
            return $tenBillions[floor($n / 10000000000)] . ($n % 10000000000 != 0 ? " " . self::underThousandToText($n % 10000000000) : "");
        } elseif ($n < 1000000000000) {
            return $hundredBillions[floor($n / 100)] . ($n % 100000000000 != 0 ? " " . self::underThousandToText(
                        $n % 100000000000
                    ) : "");
        } else {
            return "";
        }
    }

    public static function numberToUzbekText($number): string
    {
        if ($number == 0) {
            return "нол";
        }

        $integerPart = floor($number);
        $fractionPart = round(($number - $integerPart) * 100);

        $result = "";
        if ($integerPart >= 1000) {
            $result .= self::underThousandToText(floor($integerPart / 1000)) . " минг";
            $integerPart %= 1000;
            if ($integerPart > 0) {
                $result .= " ";
            }
        }

        $result .= self::underThousandToText($integerPart) . " сўм";

        if ($fractionPart > 0) {
            $result .= " " . self::underThousandToText($fractionPart) . " тийин";
        }

        return $result;
    }
}
