<?php

namespace Swark\Tests\Unit\Subscriber;

use Shopware\Components\Test\Plugin\TestCase;
use Swark\Subscriber\TransactionsCronSubscriber;
use Swark\Tests\Mocks\OrderServiceMock;

/**
 * Class TransactionsCronSubscriberTest
 *
 * @package Swark\Tests\Unit\Subscriber
 */
class TransactionsCronSubscriberTest extends TestCase
{
    protected static $ensureLoadedPlugins = [
        'Swark' => [],
    ];

    public function test_construction()
    {
        $subscriber = new TransactionsCronSubscriber(
            new OrderServiceMock()
        );

        $this->assertInstanceOf(TransactionsCronSubscriber::class, $subscriber);
    }

    public function test_getSubscribedEvents()
    {
        $events = TransactionsCronSubscriber::getSubscribedEvents();
        $this->assertCount(1, $events);
        $this->assertEquals('onRunCronjob', $events['Shopware_CronJob_SwarkCheckTransactions']);
    }
}
