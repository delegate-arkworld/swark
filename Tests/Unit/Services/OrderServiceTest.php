<?php

namespace Swark\Tests\Unit\Services;

use Shopware\Components\Test\Plugin\TestCase;
use Swark\Services\OrderService;
use Swark\Tests\Mocks\LoggerServiceMock;
use Swark\Tests\Mocks\ModelManagerMock;
use Swark\Tests\Mocks\OrderHelperMock;
use Swark\Tests\Mocks\PluginHelperMock;
use Swark\Tests\Mocks\TransactionServiceMock;

/**
 * Class OrderServiceTest
 */
class OrderServiceTest extends TestCase
{
    protected static $ensureLoadedPlugins = [
        'Swark' => [],
    ];

    public function test_construction()
    {
        $service = new OrderService(
            new ModelManagerMock(),
            new OrderHelperMock(),
            new PluginHelperMock(),
            new TransactionServiceMock(),
            [],
            new LoggerServiceMock()
        );

        $this->assertInstanceOf(OrderService::class, $service);
    }
}
