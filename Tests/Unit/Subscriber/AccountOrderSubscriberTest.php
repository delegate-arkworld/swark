<?php

namespace Swark\Tests\Unit\Subscriber;

use Shopware\Components\Test\Plugin\TestCase;
use Swark\Subscriber\AccountOrderSubscriber;

/**
 * Class AccountOrderSubscriberTest
 */
class AccountOrderSubscriberTest extends TestCase
{
    protected static $ensureLoadedPlugins = [
        'Swark' => []
    ];

    public function test_construction()
    {
        $subscriber = new AccountOrderSubscriber(
            ''
        );

        $this->assertInstanceOf(AccountOrderSubscriber::class, $subscriber);
    }
}
