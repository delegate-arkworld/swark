<?php

namespace Swark\Tests\Unit\Subscriber;

use Shopware\Components\Test\Plugin\TestCase;
use Swark\Services\TransactionService;
use Swark\Tests\Mocks\ConnectionServiceMock;
use Swark\Tests\Mocks\LoggerServiceMock;

/**
 * Class TransactionServiceTest
 */
class TransactionServiceTest extends TestCase
{
    protected static $ensureLoadedPlugins = [
        'Swark' => [],
    ];

    public function test_construction()
    {
        $service = new TransactionService(
            new ConnectionServiceMock(),
            new LoggerServiceMock()
        );

        $this->assertInstanceOf(TransactionService::class, $service);
    }
}
