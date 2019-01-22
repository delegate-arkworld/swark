<?php

namespace Swark\Tests\Unit\Subscriber;

use Shopware\Components\Test\Plugin\TestCase;
use Swark\Subscriber\CheckoutFinishSubscriber;
use Swark\Services\OrderService;
use Swark\Helper\OrderHelper;

/**
 * Class CheckoutFinishSubscriberTest
 */
class CheckoutFinishSubscriberTest extends TestCase
{
    protected static $ensureLoadedPlugins = [
        'Swark' => []
    ];

    public function testConstruction()
    {
        $subscriber = new CheckoutFinishSubscriber(
            '',
            $this->createMock(OrderService::class),
            $this->createMock(OrderHelper::class),
            ''
        );

        $this->assertInstanceOf(CheckoutFinishSubscriber::class, $subscriber);
    }

//    public function testClientService()
//    {
//        /** @var ClientService $service */
//        $service = Shopware()->Container()->get('swark.services.client_service');
//        /** @var Client $client */
//        $client = $service->getClient();
//
//        $this->assertInstanceOf(Client::class, $client);
//    }
}