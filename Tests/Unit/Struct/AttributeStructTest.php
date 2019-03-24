<?php

namespace Swark\Tests\Unit\Struct;

use Shopware\Components\Test\Plugin\TestCase;
use Swark\Struct\AttributeStruct;

/**
 * Class AttributeStructTest
 */
class AttributeStructTest extends TestCase
{
    protected static $ensureLoadedPlugins = [
        'Swark' => [],
    ];

    public function test_construction()
    {
        $struct = $this->generateStruct();

        $this->assertInstanceOf(AttributeStruct::class, $struct);
    }

    public function test_getAmount()
    {
        $struct = $this->generateStruct([
            'swarkArkAmount' => 2.64738193
        ]);

        $this->assertEquals(2.64738193, $struct->getAmount());
    }

    public function test_setAmount()
    {
        $struct = $this->generateStruct();
        $struct->setAmount(7.73918361);

        $this->assertEquals(7.73918361, $struct->getAmount());
    }

    public function test_getVendorField()
    {
        $struct = $this->generateStruct([
            'swarkVendorField' => 'VendorField Get'
        ]);

        $this->assertEquals('VendorField Get', $struct->getVendorField());
    }

    public function test_setVendorField()
    {
        $struct = $this->generateStruct();
        $struct->setVendorField('VendorField Set');

        $this->assertEquals('VendorField Set', $struct->getVendorField());
    }

    public function test_getRecipient()
    {
        $struct = $this->generateStruct([
            'swarkRecipientAddress' => 'AUDud8tvyVZa67p3QY7XPRUTjRGnWQQ9Xv'
        ]);

        $this->assertEquals('AUDud8tvyVZa67p3QY7XPRUTjRGnWQQ9Xv', $struct->getRecipient());
    }

    public function test_setRecipient()
    {
        $struct = $this->generateStruct();
        $struct->setRecipient('ALgvTAoz5Vi9easHqBK6aEMKatHb4beCXm');

        $this->assertEquals('ALgvTAoz5Vi9easHqBK6aEMKatHb4beCXm', $struct->getRecipient());
    }

    public function test_getTransactionId()
    {
        $struct = $this->generateStruct([
            'swarkTransactionId' => 'e607ffc441482e494cc8fbffce0e0a9584c36c55f947efdf6d334b53ac3e7c23'
        ]);

        $this->assertEquals('e607ffc441482e494cc8fbffce0e0a9584c36c55f947efdf6d334b53ac3e7c23', $struct->getTransactionId());
    }

    public function test_setTransactionId()
    {
        $struct = $this->generateStruct();
        $struct->setTransactionId('e1b7b3075355577c8163197d1ce6adac1bffe44b200202b871da6ed16d4f73fc');

        $this->assertEquals('e1b7b3075355577c8163197d1ce6adac1bffe44b200202b871da6ed16d4f73fc', $struct->getTransactionId());
    }

    public function test_toArray()
    {
        $struct = $this->generateStruct();
        $data = $struct->toArray();

        $this->assertEquals('fb39751eed0c0b0e6e05dced86d5deb6dd8e4a59b859b37fbf257c9ad8d54891', $data['swarkTransactionId']);
        $this->assertEquals(0.00000001, $data['swarkArkAmount']);
        $this->assertEquals('AUDud8tvyVZa67p3QY7XPRUTjRGnWQQ9Xv', $data['swarkRecipientAddress']);
        $this->assertEquals('Test', $data['swarkVendorField']);
    }

    /**
     * @param array $custom
     *
     * @return AttributeStruct
     */
    private function generateStruct(array $custom = []): AttributeStruct
    {
        $data = [
            'swarkTransactionId' => 'fb39751eed0c0b0e6e05dced86d5deb6dd8e4a59b859b37fbf257c9ad8d54891',
            'swarkArkAmount' => 0.00000001,
            'swarkRecipientAddress' => 'AUDud8tvyVZa67p3QY7XPRUTjRGnWQQ9Xv',
            'swarkVendorField' => 'Test',
        ];

        $data = array_merge($data, $custom);

        return new AttributeStruct(
            $data['swarkTransactionId'],
            $data['swarkArkAmount'],
            $data['swarkRecipientAddress'],
            $data['swarkVendorField']
        );
    }
}
