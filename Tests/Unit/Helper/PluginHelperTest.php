<?php

namespace Swark\Tests\Unit\Helper;

use Shopware\Components\Test\Plugin\TestCase;
use Swark\Helper\PluginHelper;
use Swark\Tests\Mocks\ModelManagerMock;

/**
 * Class PluginHelperTest
 */
class PluginHelperTest extends TestCase
{
    protected static $ensureLoadedPlugins = [
        'Swark' => [],
    ];

    public function test_construction()
    {
        $helper = new PluginHelper(
            '',
            new ModelManagerMock(),
            []
        );

        $this->assertInstanceOf(PluginHelper::class, $helper);
    }
}
