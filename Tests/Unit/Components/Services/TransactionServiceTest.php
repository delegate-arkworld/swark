<?php

namespace Swark\Tests\Unit\Components\Services;

use Shopware\Components\Test\Plugin\TestCase;
use Swark\Components\Services\TransactionService;
use BrianFaust\Ark\Client;

/**
 * Class TransactionServiceTest
 */
class TransactionServiceTest extends TestCase
{
    protected static $ensureLoadedPlugins = [
        'Swark' => []
    ];

//    public function testTransactionService()
//    {
//        /** @var TransactionService $service */
//        $service = Shopware()->Container()->get('swark.components.services.transaction_service');
//        /** @var Client $client */
//        $client = $service->getClient();
//
//        $this->assertInstanceOf(Client::class, $client);
//    }
}