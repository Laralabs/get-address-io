<?php

namespace Laralabs\GetAddress\Tests\Unit\Http;

use Laralabs\GetAddress\Http\Client;
use Laralabs\GetAddress\Tests\TestCase;

class ClientTest extends TestCase
{
    /** @test */
    public function it_can_enable_admin_mode_on_the_client_and_check_if_enabled(): void
    {
        $client = new Client();

        $this->assertFalse($client->isAdminMode());

        $client->admin();

        $this->assertTrue($client->isAdminMode());
    }
}
