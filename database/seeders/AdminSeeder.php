<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Transport;
use App\Enums\CategoryType;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->createTransportCategories();
        $this->createTransports();
    }

    private function createTransportCategories(): void
    {
        $categories = [
            'Light Duty',
            'Medium Duty',
            'Heavy Duty',
            'Motorcycle',
            'Bus',
            'Truck',
            'Trailer',
        ];

        if (Category::count() >= count($categories)) {
            return;
        }

        foreach ($categories as $category) {
            Category::create([
                'title' => $category,
                'type' => CategoryType::Auto,
            ]);
        }
    }

    private function createTransports(): void
    {
        // do not create if 10 transports already exist
        if (Transport::count() >= 10) {
            return;
        }

        Transport::factory()
            ->count(10)
            ->create()
            ->each(function (Transport $transport) {
                $transport->categories()->attach(
                    Category::inRandomOrder()->limit(2)->get()
                );
            });
    }

}
