<?php

namespace App\Services;

use Exception;
use Throwable;
use Carbon\Carbon;
use App\Models\Lot;
use App\Models\User;
use App\Models\LotUser;
use App\Enums\LotStatus;
use App\Models\LotUserStep;
use App\Enums\LotPaymentStatus;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Exception\GuzzleException;

class LotService
{
    public function __construct(private readonly SmsService $smsService) {}

    /**
     * @throws Exception|GuzzleException
     */
    public function applyLot(Lot $lot): void
    {
        $this->guardAlreadyApplied($lot);

        // Create a new step for the user
        LotUser::createOrFirst([
            'lot_id' => $lot->id,
            'user_id' => auth()->id(),
        ]);

        // Send SMS to the user with the lot number
        /** @var User $user */
        $user = auth()->user();

        $body = <<<TEXT
#$lot->number лотга аризангиз кабул килинди.
Фишка ракамингиз: $user->lots_member_number
TEXT;
        $user->messages()->create([
            'title' => "Лотга ариза кабул килинди",
            'body' => $body,
        ]);
        $this->smsService->sendSms(
            auth()->user()->phone,
            <<<TEXT
$body

Батафсил: {$lot->getLink()}
TEXT
        );
    }

    public function startActiveLots(): void
    {
        // Get all lots that are not started yet and should be started
        $lots = Lot::query()
            ->where('starts_at', '<=', now())
            ->where('status', LotStatus::Active)
            ->get();

        // Start each lot
        /** @var Lot $lot */
        foreach ($lots as $lot) {
            try {
                $this->startLot($lot);
            } catch (Throwable $e) {
                logger()->error($e);
            }
        }
    }

    /**
     * @throws Throwable
     */
    public function startLot(Lot $lot): void
    {
        $this->guardAlreadyStarted($lot);
        $this->guardCanBeStarted($lot);

        $lot->updateOrFail(['status' => LotStatus::Started]);

        foreach ($lot->users as $user) {
            try {
                $title = "Аукцион бошланди!";
                $body = <<<TEXT
#$lot->number Рақамли лот аукциони бошланди!
TEXT;

                $user->messages()->create([
                    'title' => $title,
                    'body' => $body,
                ]);
                $this->smsService->sendSms(
                    $user->phone,
                    <<<TEXT
$body

Батафсил: {$lot->getLink()}
TEXT
                );
            } catch (Throwable $e) {
                logger()->error($e);
            }
        }
    }

    public function endLots(): void
    {
        // Get all lots that are not ended yet and should be ended
        $lots = Lot::query()
            ->where('ends_at', '<=', now())
            ->where('status', LotStatus::Started)
            ->get();

        // End each lot
        /** @var Lot $lot */
        foreach ($lots as $lot) {
            try {
                $this->endLot($lot);
            } catch (Throwable $e) {
                logger()->error($e);
            }
        }
    }

    /**
     * @throws Throwable
     */
    public function endLot(Lot $lot): void
    {
        $this->guardAlreadyEnded($lot);
        $this->guardCanBeEnded($lot);

        DB::beginTransaction();
        try {
            $paymentDeadline = null;

            /** @var LotUserStep $winnerStep */
            $winnerStep = $lot->steps()->orderByDesc('price')->first();
            if ($winnerStep) {
                $lotUser = $winnerStep->lotUser;
                $lotUser->updateOrFail(['is_winner' => true]);
                $this->sendSmsToWinner($lot, $lotUser);

                $paymentDeadline = $this->getPaymentDeadline();
            }

            $lot->updateOrFail([
                'status' => LotStatus::Ended,
                'payment_status' => LotPaymentStatus::NotPaid,
                'payment_deadline' => $paymentDeadline,
            ]);

            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function getPaymentDeadline(): Carbon
    {
        return now()->addDays(10);
    }

    /**
     * @throws GuzzleException
     */
    public function sendSmsToWinner(Lot $lot, LotUser $winner): void
    {
        $body = <<<TEXT
Табриклаймиз! Сиз #$lot->number рақамли лотда г'олиб бўлдингиз!
Сиз 10 кун ичида {$winner->lastStep->price} сўм миқдорида тўловни амалга оширишингиз керак. Акс ҳолда, лот бекор қилинади.
TEXT;

        $winner->user->messages()->create([
            'title' => "#$lot->number рақамли лотда г'олиб бўлдингиз",
            'body' => $body
        ]);

        $this->smsService->sendSms(
            $winner->user->phone,
            <<<TEXT
$body

Батафсил: {$lot->getLink()}
TEXT
        );
    }


    /**
     * @throws Exception
     */
    private function guardAlreadyStarted(Lot $lot): void
    {
        if ($lot->status === LotStatus::Started) {
            throw new Exception('Аукцион аллақачон бошланган');
        }
    }

    /**
     * @throws Exception
     */
    private function guardCanBeStarted(Lot $lot): void
    {
        if (!$lot->isCanBeStarted()) {
            throw new Exception('Аукцион бошлана олмайди');
        }
    }

    /**
     * @throws Exception
     */
    private function guardAlreadyEnded(Lot $lot): void
    {
        if ($lot->status === LotStatus::Ended) {
            throw new Exception('Аукцион аллақачон тугаган');
        }
    }

    /**
     * @throws Exception
     */
    private function guardCanBeEnded(Lot $lot): void
    {
        if (!$lot->isCanBeEnded()) {
            throw new Exception('Аукцион тугатила олмайди');
        }
    }

    /**
     * @throws Exception
     */
    private function guardAlreadyApplied(Lot $lot): void
    {
        if ($lot->isApplied()) {
            throw new Exception('Сиз бу лотга аллақачон ариза бергансиз');
        }
    }
}
