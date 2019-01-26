<?php

namespace Swark\Tests\Unit\Subscriber;

use Shopware\Components\Test\Plugin\TestCase;
use Shopware\Models\Order\Order;
use Swark\Helper\OrderHelper;
use Swark\Tests\Mocks\ModelManagerMock;
use Swark\Tests\Mocks\OrderHelperMock;
use Swark\Tests\Mocks\PluginHelperMock;

/**
 * Class OrderHelperTest
 */
class OrderHelperTest extends TestCase
{
    protected static $ensureLoadedPlugins = [
        'Swark' => []
    ];

    public function test_construction()
    {
        $helper = new OrderHelper(
            new ModelManagerMock(),
            new PluginHelperMock(),
            []
        );

        $this->assertInstanceOf(OrderHelper::class, $helper);
    }

    /*public function test_get_orders()
    {
        $helper = new OrderHelperMock();

        $this->assertIsArray($helper->getOrders(), 'returned type must be an array');
    }

    public function test_get_order()
    {
        $helper = new OrderHelperMock();

        $this->assertInstanceOf(Order::class, $helper->getOrder(1));
    }*/
}
