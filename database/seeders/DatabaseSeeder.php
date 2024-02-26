<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if (!User::where('email', env('ADMIN_EMAIL'))->exists()) {
            User::create([
                'name' => 'Admin',
                'email' => env('ADMIN_EMAIL'),
                'phone' => '998977777777',
                'password' => Hash::make(env('ADMIN_PASSWORD')),
                'is_admin' => true,
            ]);
        }
    }
}
