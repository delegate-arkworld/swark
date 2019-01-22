<?php

namespace Swark\Tests\Unit\Subscriber;

use Shopware\Components\Test\Plugin\TestCase;
use Swark\Subscriber\CheckoutFinishSubscriber;
use Enlight\Event\SubscriberInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Swark\OrderProcessor;

/**
 * Class CheckoutSubscriberTest
 */
class CheckoutSubscriberTest extends TestCase
{
    protected static $ensureLoadedPlugins = [
        'Swark' => []
    ];

    public function testConstruction()
    {
        $subscriber = new CheckoutFinishSubscriber(
            $this->createMock(ContainerInterface::class),
            '',
            $this->createMock(OrderProcessor::class)
        );

        $this->assertInstanceOf(SubscriberInterface::class, $subscriber);
        $this->assertInstanceOf(CheckoutFinishSubscriber::class, $subscriber);
    }

    public function testSubscribedEvents()
    {
        $this->assertSame(
            [
                'Enlight_Controller_Action_PostDispatchSecure_Frontend_Checkout' => 'onPostDispatchSecureCheckout',
                'Shopware_Modules_Order_SaveOrder_ProcessDetails' => 'onOrderSaveOrderProcessDetails'
            ],
            CheckoutFinishSubscriber::getSubscribedEvents()
        );
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