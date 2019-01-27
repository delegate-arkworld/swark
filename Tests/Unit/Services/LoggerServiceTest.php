<?php

namespace Swark\Tests\Unit\Subscriber;

use Shopware\Components\Test\Plugin\TestCase;
use Swark\Services\LoggerService;
use Swark\Tests\Mocks\LoggerMock;

/**
 * Class LoggerServiceTest
 */
class LoggerServiceTest extends TestCase
{
    protected static $ensureLoadedPlugins = [
        'Swark' => [],
    ];

    public function test_construction()
    {
        $service = new LoggerService(
            new LoggerMock()
        );

        $this->assertInstanceOf(LoggerService::class, $service);
    }
}
