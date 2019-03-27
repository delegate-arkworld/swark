<?php

namespace Swark\Tests\Unit\Command;

use Shopware\Components\Test\Plugin\TestCase;
use Swark\Command\TestConfigurationCommand;

/**
 * Class TestConfigurationCommandTest
 */
class TestConfigurationCommandTest extends TestCase
{
    protected static $ensureLoadedPlugins = [
        'Swark' => [],
    ];

    public function test_construction()
    {
        $command = new TestConfigurationCommand(
        );

        $this->assertInstanceOf(TestConfigurationCommand::class, $command);
    }
}
