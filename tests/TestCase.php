<?php

namespace Tests;

use App\Models\Transport;
use Mockery\MockInterface;
use App\Services\SmsService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use RefreshDatabase;

    protected readonly MockInterface $smsServiceMock;

    protected function setUp(): void
    {
        parent::setUp();

        Transport::factory()->count(10)->create();

        $this->smsServiceMock = $this->mock(SmsService::class);
    }
}
