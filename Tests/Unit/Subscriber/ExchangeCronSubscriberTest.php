<?php

namespace Swark\Tests\Unit\Subscriber;

use Shopware\Components\Test\Plugin\TestCase;
use Swark\Subscriber\ExchangeCronSubscriber;
use Swark\Tests\Mocks\ExchangeServiceMock;

/**
 * Class ExchangeCronSubscriberTest
 */
class ExchangeCronSubscriberTest extends TestCase
{
    protected static $ensureLoadedPlugins = [
        'Swark' => [],
    ];

    public function test_construction()
    {
        $subscriber = new ExchangeCronSubscriber(
            new ExchangeServiceMock()
        );

        $this->assertInstanceOf(ExchangeCronSubscriber::class, $subscriber);
    }
}
