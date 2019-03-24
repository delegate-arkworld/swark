<?php

namespace Swark\Tests\Unit\Subscriber;

use Shopware\Components\Test\Plugin\TestCase;
use Swark\Subscriber\SaveOrderSubscriber;
use Swark\Tests\Mocks\OrderServiceMock;

/**
 * Class SaveOrderSubscriberTest
 *
 * @package Swark\Tests\Unit\Subscriber
 */
class SaveOrderSubscriberTest extends TestCase
{
    protected static $ensureLoadedPlugins = [
        'Swark' => [],
    ];

    public function test_construction()
    {
        $subscriber = new SaveOrderSubscriber(
            new OrderServiceMock()
        );

        $this->assertInstanceOf(SaveOrderSubscriber::class, $subscriber);
    }

    public function test_getSubscribedEvents()
    {
        $events = SaveOrderSubscriber::getSubscribedEvents();
        $this->assertCount(1, $events);
        $this->assertEquals('onOrderSaveOrderProcessDetails', $events['Shopware_Modules_Order_SaveOrder_ProcessDetails']);
    }
}
