<?php

namespace Swark\Tests\Unit\Subscriber;

use Shopware\Components\Test\Plugin\TestCase;
use Swark\Subscriber\TransactionsCronSubscriber;
use Swark\Tests\Mocks\OrderServiceMock;

/**
 * Class TransactionsCronSubscriberTest
 */
class TransactionsCronSubscriberTest extends TestCase
{
    protected static $ensureLoadedPlugins = [
        'Swark' => []
    ];

    public function test_construction()
    {
        $subscriber = new TransactionsCronSubscriber(
            new OrderServiceMock()
        );

        $this->assertInstanceOf(TransactionsCronSubscriber::class, $subscriber);
    }
}
