<?php

namespace Swark\Tests\Unit\Services;

use Shopware\Components\Test\Plugin\TestCase;
use Swark\Services\ConnectionService;

/**
 * Class ConnectionServiceTest
 */
class ConnectionServiceTest extends TestCase
{
    protected static $ensureLoadedPlugins = [
        'Swark' => [],
    ];

    public function test_construction()
    {
        $service = new ConnectionService(
            []
        );

        $this->assertInstanceOf(ConnectionService::class, $service);
    }
}
