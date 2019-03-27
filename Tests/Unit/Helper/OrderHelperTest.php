<?php

namespace Swark\Tests\Unit\Helper;

use Shopware\Components\Test\Plugin\TestCase;
use Swark\Helper\OrderHelper;
use Swark\Tests\Mocks\ModelManagerMock;
use Swark\Tests\Mocks\PluginHelperMock;

/**
 * Class OrderHelperTest
 */
class OrderHelperTest extends TestCase
{
    protected static $ensureLoadedPlugins = [
        'Swark' => [],
    ];

    public function test_construction()
    {
        $helper = new OrderHelper(
            new ModelManagerMock(),
            new PluginHelperMock(),
            []
        );

        $this->assertInstanceOf(OrderHelper::class, $helper);
    }
}
