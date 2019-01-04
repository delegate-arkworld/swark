<?php

namespace Swark\Tests\Unit\Components\Services;

use Shopware\Components\Test\Plugin\TestCase;
use Swark\Components\Helper\PluginHelper;
use Shopware\Models\Plugin\Plugin;
use Shopware\Models\Payment\Payment;

/**
 * Class PluginHelperTest
 */
class PluginHelperTest extends TestCase
{
    /**
     * @var PluginHelper $helper
     */
    private $helper;

    /**
     * @throws \Exception
     */
    protected function setUp()
    {
        parent::setUp();

        $this->helper = Shopware()->Container()->get('swark.components.helper.plugin_helper');
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
    public function testGetPluginId()
    {
        $this->assertInternalType('int', $this->helper->getPluginId());
    }

    /**
     * @throws \Exception
     */
    public function testGetPluginObject()
    {
        /** @var Plugin $object */
        $object = $this->helper->getPluginObject();

        $this->assertInstanceOf(Plugin::class, $object);
    }

    /**
     * @throws \Exception
     */
    public function testGetPaymentObject()
    {
        /** @var Payment $object */
        $object = $this->helper->getPaymentObject();

        $this->assertInstanceOf(Payment::class, $object);
    }

    /**
     *
     */
    public function testCheckPlugin()
    {
        // TODO: Get PluginId and check
    }
}
