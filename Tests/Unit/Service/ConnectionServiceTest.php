<?php

namespace Swark\Tests\Unit\Service;

use Shopware\Components\Test\Plugin\TestCase;
use Swark\Service\ConnectionService;

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
