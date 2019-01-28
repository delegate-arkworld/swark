<?php

namespace Swark\Tests\Unit\Commands;

use Shopware\Components\Test\Plugin\TestCase;
use Swark\Commands\CheckTransactionsCommand;
use Swark\Tests\Mocks\OrderServiceMock;

/**
 * Class CheckTransactionsCommandTest
 */
class CheckTransactionsCommandTest extends TestCase
{
    protected static $ensureLoadedPlugins = [
        'Swark' => [],
    ];

    public function test_construction()
    {
        $command = new CheckTransactionsCommand(
            new OrderServiceMock()
        );

        $this->assertInstanceOf(CheckTransactionsCommand::class, $command);
    }
}
