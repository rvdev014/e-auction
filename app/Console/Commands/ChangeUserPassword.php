<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class ChangeUserPassword extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:change-user-password {user} {pass}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $userId = $this->argument('user');
        $password = $this->argument('pass');

        $user = User::find($userId);
        if (!$user) {
            $this->error('User not found');
            return;
        }

        $user->updateOrFail(['password' => Hash::make($password)]);
    }
}
