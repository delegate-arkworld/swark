<?php

namespace Swark\Tests\Unit\Components\Services;

use Shopware\Components\Test\Plugin\TestCase;
use Swark\Components\Services\ExchangeService;
use ArkEcosystem\Client\ConnectionManager;
use Shopware\Components\HttpClient\GuzzleHttpClient;
use Shopware\Components\HttpClient\RequestException;
use Shopware\Components\HttpClient\Response;

/**
 * Class ExchangeServiceTest
 */
class ExchangeServiceTest extends TestCase
{
    /**
     * @var ExchangeService $service
     */
    private $service;

    /**
     * @throws \Exception
     */
    protected function setUp()
    {
        parent::setUp();

        $this->service = Shopware()->Container()->get('swark.components.services.exchange_service');
    }

    /**
     * @var array
     */
    protected static $ensureLoadedPlugins = [
        'Swark' => []
    ];

    /**
     */
    public function testUpdateExchangeRate()
    {
        $manager = $this->service->updateExchangeRate();

        $this->ass(ConnectionManager::class, $manager);
    }

    /**
     */
    public function testGetExchangeRate()
    {
        /** @var ConnectionManager $manager */
        $manager = $this->service->getConnectionManager();

        $this->assertInstanceOf(ConnectionManager::class, $manager);
    }

}