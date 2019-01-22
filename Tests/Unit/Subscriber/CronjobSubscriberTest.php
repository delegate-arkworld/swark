<?php

namespace Swark\Tests\Unit\Subscriber;

use Shopware\Components\Test\Plugin\TestCase;
use Swark\Subscriber\CronjobSubscriber;
use Swark\Components\OrderProcessor;

/**
 * Class CronjobSubscriberTest
 */
class CronjobSubscriberTest extends TestCase
{
    protected static $ensureLoadedPlugins = [
        'Swark' => []
    ];

    public function testConstruction()
    {
        $subscriber = new CronjobSubscriber(
            $this->createMock(OrderProcessor::class)
        );

        $this->assertInstanceOf(CronjobSubscriber::class, $subscriber);
    }

//    public function testOnRunCronjob()
//    {
//        // TODO: add test
//    }

//    public function testClientService()
//    {
//        /** @var ClientService $service */
//        $service = Shopware()->Container()->get('swark.components.services.client_service');
//        /** @var Client $client */
//        $client = $service->getClient();
//
//        $this->assertInstanceOf(Client::class, $client);
//    }
}