<?php

namespace Swark\Tests\Unit\Subscriber;

use Shopware\Components\Test\Plugin\TestCase;
use Swark\Subscriber\SaveOrderSubscriber;
use Swark\Tests\Mocks\OrderServiceMock;

/**
 * Class SaveOrderSubscriberTest
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
}
