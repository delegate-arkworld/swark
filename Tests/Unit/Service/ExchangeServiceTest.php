<?php

namespace Swark\Tests\Unit\Service;

use Shopware\Components\Test\Plugin\TestCase;
use Swark\Service\ExchangeService;
use Swark\Tests\Mocks\GuzzleHttpClientMock;
use Swark\Tests\Mocks\LoggerServiceMock;
use Swark\Tests\Mocks\ModelManagerMock;

/**
 * Class ExchangeServiceTest
 */
class ExchangeServiceTest extends TestCase
{
    protected static $ensureLoadedPlugins = [
        'Swark' => [],
    ];

    public function test_construction()
    {
        $service = new ExchangeService(
            new GuzzleHttpClientMock(),
            new LoggerServiceMock(),
            new ModelManagerMock()
        );

        $this->assertInstanceOf(ExchangeService::class, $service);
    }
}
