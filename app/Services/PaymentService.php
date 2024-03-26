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

}
