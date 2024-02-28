<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Category;
use App\Models\Transport;

class TransportRelationsTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Category::factory()->count(5)->create();
    }

    public function test_attach_categories_to_transport(): void
    {
        $transport = Transport::factory()->create();
        $categories = Category::inRandomOrder()->limit(2)->get();
        $transport->categories()->attach($categories);

        $transport->refresh();

        $this->assertEquals(2, $transport->categories()->count());
    }
}
