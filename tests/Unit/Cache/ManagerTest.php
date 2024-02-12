<?php

namespace Laralabs\GetAddress\Tests\Unit\Cache;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laralabs\GetAddress\Cache\Manager;
use Laralabs\GetAddress\Models\CachedAddress;
use Laralabs\GetAddress\Tests\TestCase;

class ManagerTest extends TestCase
{
    use RefreshDatabase;

    protected ?Manager $manager = null;

    public function setUp(): void
    {
        parent::setUp();

        $this->manager = new Manager();
    }

    /** @test */
    public function it_can_check_for_cached_addresses_with_postcode(): void
    {
        CachedAddress::factory()->create(['line_1' => '1 Example Street', 'postcode' => 'ABC 123']);
        CachedAddress::factory()->create(['line_1' => '2 Example Street', 'postcode' => 'ABC 123']);
        CachedAddress::factory()->create(['line_1' => '3 Example Street', 'postcode' => 'ABC 321']);

        $result = $this->manager->checkCache('ABC 123', null);

        $this->assertCount(2, $result['addresses'] ?? 0);
    }

    /** @test */
    public function it_can_check_for_cached_addresses_with_postcode_and_property_number(): void
    {
        CachedAddress::factory()->create(['line_1' => '1 Example Street', 'postcode' => 'ABC 123']);
        CachedAddress::factory()->create(['line_1' => '2 Example Street', 'postcode' => 'ABC 123']);
        CachedAddress::factory()->create(['line_1' => '3 Example Street', 'postcode' => 'ABC 321']);

        $result = $this->manager->checkCache('ABC 123', 1);

        $this->assertCount(1, $result['addresses'] ?? 0);
        $this->assertEquals('1 Example Street', $result['addresses'][0]['line_1']);
        $this->assertEquals('ABC 123', $result['postcode']);
    }
}