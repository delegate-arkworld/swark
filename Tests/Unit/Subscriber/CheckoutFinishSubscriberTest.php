<?php

namespace Swark\Tests\Unit\Subscriber;

use Shopware\Components\Test\Plugin\TestCase;
use Swark\Subscriber\CheckoutFinishSubscriber;
use Swark\Tests\Mocks\OrderHelperMock;
use Swark\Tests\Mocks\OrderServiceMock;

/**
 * Class CheckoutFinishSubscriberTest
 */
class CheckoutFinishSubscriberTest extends TestCase
{
    protected static $ensureLoadedPlugins = [
        'Swark' => []
    ];

    public function test_construction()
    {
        $subscriber = new CheckoutFinishSubscriber(
            '',
            new OrderServiceMock(),
            new OrderHelperMock(),
            []
        );

        $this->assertInstanceOf(CheckoutFinishSubscriber::class, $subscriber);
    }
}
