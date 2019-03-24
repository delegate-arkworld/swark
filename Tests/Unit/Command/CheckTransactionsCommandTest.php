<?php

namespace Swark\Tests\Unit\Command;

use Shopware\Components\Test\Plugin\TestCase;
use Swark\Command\CheckTransactionsCommand;
use Swark\Tests\Mocks\OrderServiceMock;

/**
 * Class CheckTransactionsCommandTest
 *
 * @package Swark\Tests\Unit\Command
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
