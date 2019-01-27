<?php

namespace Swark\Tests\Unit\Subscriber;

use Shopware\Components\Test\Plugin\TestCase;
use Swark\Commands\TestConfigurationCommand;

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
