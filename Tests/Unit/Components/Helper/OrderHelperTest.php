<?php

namespace Swark\Tests\Unit\Components\Services;

use Shopware\Components\Test\Plugin\TestCase;
use Swark\Components\Helper\OrderHelper;
use Shopware\Models\Order\Order;
use Shopware\Models\Order\Status;

/**
 * Class OrderHelperTest
 */
class OrderHelperTest extends TestCase
{
    /**
     * @var OrderHelper $helper
     */
    private $helper;

    /**
     * @throws \Exception
     */
    protected function setUp()
    {
        parent::setUp();

        $this->helper = Shopware()->Container()->get('swark.components.helper.order_helper');
    }

    protected static $ensureLoadedPlugins = [
        'Swark' => []
    ];

    public function testGetOrders()
    {
        // TODO: Create 3 Orders, make 2 open and 1 close (summary with testGetOpenOrders function). Expect 3 Orders
    }

    public function testGetOrder()
    {
        // TODO: Create Order and get it
    }

    public function testGetOpenOrders()
    {
        // TODO: Create 3 Orders, make 2 open and 1 close (summary with testGetOpenOrders function). Expect 2 open
    }

    public function testGetClosedOrders()
    {
        // TODO: Create 3 Orders, make 2 open and 1 close (summary with testGetOpenOrders function). Expect 1 closed
        //
    }

    public function testCheckPayment()
    {
        // TODO: Get Payment Object and expect true
    }

    public function testGetOrderAttributes()
    {
        /** @var Order $order */
        $order = new Order();

        /** @var \Shopware\Models\Attribute\Order $attributes */
        $orderAttributes = $order->getAttribute();

        $attributes = $this->helper->getOrderAttributes($orderAttributes);

        $this->assertArrayHasKey('swarkTransactionId', $attributes);
        $this->assertArrayHasKey('swarkArkAmount', $attributes);
        $this->assertArrayHasKey('swarkRecipientAddress', $attributes);
        $this->assertArrayHasKey('swarkVendorField', $attributes);
    }

    public function testGetAmountByOrder()
    {
        /** @var Order $order */
        $order = new Order();

        /** @var \Shopware\Models\Attribute\Order $attributes */
        $attributes = $order->getAttribute();

        $attributes->setSwarkArkAmount(13.783);

        $this->assertEquals(
            13.783,
            $attributes->getSwarkArkAmount()
        );
    }

    public function testGetRecipientAddressByOrder()
    {
        /** @var Order $order */
        $order = new Order();

        /** @var \Shopware\Models\Attribute\Order $attributes */
        $attributes = $order->getAttribute();

        $attributes->setSwarkRecipientAddress('AWDdMBebDW56ffwisTNrHQ8yQZgiVbisDQ');

        $this->assertEquals(
            'AWDdMBebDW56ffwisTNrHQ8yQZgiVbisDQ',
            $attributes->getSwarkRecipientAddress()
        );
    }

    public function testGetVendorFieldByOrder()
    {
        /** @var Order $order */
        $order = new Order();

        /** @var \Shopware\Models\Attribute\Order $attributes */
        $attributes = $order->getAttribute();

        $attributes->setSwarkVendorField('payment_SWAG000001');

        $this->assertEquals(
            'payment_SWAG000001',
            $attributes->getSwarkVendorField()
        );
    }

    public function testGetTransactionIdByOrder()
    {
        /** @var Order $order */
        $order = new Order();

        /** @var \Shopware\Models\Attribute\Order $attributes */
        $attributes = $order->getAttribute();

        $attributes->setSwarkTransactionId('8a256d604da7f2d79b2fbe7f3ca11f0168b544cb4919bb29415a487f1dcef212');

        $this->assertEquals(
            '8a256d604da7f2d79b2fbe7f3ca11f0168b544cb4919bb29415a487f1dcef212',
            $attributes->getSwarkTransactionId()
        );
    }

    public function testGetVendorFieldLayout()
    {
        /** @var Order $order */
        $order = new Order();

        $orderNumber = $order->getNumber();

        // TODO: get pluginConfig value
        $pluginConfig = 'Order: {$ordernumber}';

        $this->assertEquals(
            \str_replace('{$ordernumber}', $orderNumber, $pluginConfig),
            $this->helper->getVendorFieldLayout($orderNumber)
        );
    }

}

