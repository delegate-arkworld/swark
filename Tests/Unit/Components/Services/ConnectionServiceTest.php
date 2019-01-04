<?php

namespace Swark\Tests\Unit\Components\Services;

use Shopware\Components\Test\Plugin\TestCase;
use Swark\Components\Services\ConnectionService;
use ArkEcosystem\Client\ConnectionManager;

/**
 * Class ConnectionServiceTest
 */
class ConnectionServiceTest extends TestCase
{
    /**
     * @var ConnectionService $service
     */
    private $service;

    /**
     * @throws \Exception
     */
    protected function setUp()
    {
        parent::setUp();

        $this->service = Shopware()->Container()->get('swark.components.services.connection_service');
    }

    /**
     * @var array
     */
    protected static $ensureLoadedPlugins = [
        'Swark' => []
    ];

    /**
     * @throws \Exception
     */
    public function testGetConnectionManager()
    {
        /** @var ConnectionManager $manager */
        $manager = $this->service->getConnectionManager();

        $this->assertInstanceOf(ConnectionManager::class, $manager);
    }

}