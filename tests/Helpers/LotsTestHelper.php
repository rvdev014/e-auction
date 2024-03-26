<?php

namespace Tests\Helpers;

use App\Models\Lot;
use App\Models\User;
use App\Models\LotUser;

trait LotsTestHelper
{
    private function addUserApplicationsToLot(Lot $lot, int $usersCount = 3, bool $withSteps = false): void
    {
        /** @var User[] $lotUsers */
        $lotUsers = User::factory()->count($usersCount)->create();
        foreach ($lotUsers as $user) {
            /** @var LotUser $lotUser */
            $lotUser = $lot->lotUsers()->create([
                'user_id' => $user->id,
            ]);

            if ($withSteps) {
                $lotUser->steps()->createMany([
                    ['user_id' => $user->id, 'price' => rand(1000, 10000)],
                    ['user_id' => $user->id, 'price' => rand(1000, 10000)],
                    ['user_id' => $user->id, 'price' => rand(1000, 10000)]
                ]);
            }
        }
    }
}
