<?php

namespace Swark\Tests\Unit\Subscriber;

use Shopware\Components\Test\Plugin\TestCase;
use Swark\Subscriber\AccountOrderSubscriber;
use Swark\Tests\Mocks\OrderHelperMock;

/**
 * Class AccountOrderSubscriberTest
 */
class AccountOrderSubscriberTest extends TestCase
{
    protected static $ensureLoadedPlugins = [
        'Swark' => [],
    ];

    public function test_construction()
    {
        $subscriber = new AccountOrderSubscriber(
            '',
            new OrderHelperMock()
        );

        $this->assertInstanceOf(AccountOrderSubscriber::class, $subscriber);
    }

    public function test_getSubscribedEvents()
    {
        $events = AccountOrderSubscriber::getSubscribedEvents();
        $this->assertCount(1, $events);
        $this->assertEquals('onPostDispatchSecureAccount', $events['Enlight_Controller_Action_PostDispatchSecure_Frontend_Account']);
    }
}
