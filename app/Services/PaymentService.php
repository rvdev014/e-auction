<?php

namespace App\Services;

use App\Models\LotWinningReport;
use Throwable;
use App\Models\Lot;
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

    public static function numberToUzbekText($number): string
    {
        $largeNumbers = ["", " минг", " миллион", " миллиард", " триллион"];  // Add more if needed

        if ($number == 0) {
            return "нол";
        }

        $integerPart = floor($number);
        $fractionPart = round(($number - $integerPart) * 100);

        $result = "";
        $groupIndex = 0;

        while ($integerPart > 0) {
            $remainder = $integerPart % 1000;
            if ($remainder > 0) {
                $result = self::underThousandToText($remainder) . $largeNumbers[$groupIndex] . ($result ? " " . $result : "");
            }
            $integerPart = floor($integerPart / 1000);
            $groupIndex++;
        }

        if ($fractionPart > 0) {
            $result .= " " . self::underThousandToText($fractionPart) . " тийин";
        }

        return $result;
    }

    public static function underThousandToText($n): string
    {
        $ones = ["", "бир", "икки", "уч", "тўрт", "беш", "олти", "етти", "саккиз", "тўққиз"];
        $tens = ["", "ўн", "йигирма", "ўттиз", "қирқ", "эллик", "олтмиш", "етмиш", "саксон", "тўқсон"];
        $hundreds = ["", "юз", "икки юз", "уч юз", "тўрт юз", "беш юз", "олти юз", "етти юз", "саккиз юз", "тўққиз юз"];

        if ($n == 0) {
            return "";
        } elseif ($n < 10) {
            return $ones[$n];
        } elseif ($n < 100) {
            return $tens[floor($n / 10)] . ($n % 10 != 0 ? " " . $ones[$n % 10] : "");
        } else {
            return $hundreds[floor($n / 100)] . ($n % 100 >= 10 ? " " . $tens[floor(
                        ($n % 100) / 10
                    )] : "") . ($n % 10 != 0 ? " " . $ones[$n % 10] : "");
        }
    }
}
