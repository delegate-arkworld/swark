<?php

namespace Swark\Tests\Unit\Struct;

use Shopware\Components\Test\Plugin\TestCase;
use Swark\Struct\TimestampStruct;
use Swark\Struct\TransactionStruct;
use Swark\Tests\Mocks\TimestampStructMock;

/**
 * Class TransactionStructTest
 */
class TransactionStructTest extends TestCase
{
    protected static $ensureLoadedPlugins = [
        'Swark' => [],
    ];

    public function test_construction()
    {
        $struct = $this->generateStruct();

        $this->assertInstanceOf(TransactionStruct::class, $struct);
    }

    public function test_getId()
    {
        $struct = $this->generateStruct([
            'id' => 'c5a4721181265e33e18984dff79842c6e8cbefd9cb7c1d9d40a4103f816229cd'
        ]);

        $this->assertEquals('c5a4721181265e33e18984dff79842c6e8cbefd9cb7c1d9d40a4103f816229cd', $struct->getId());
    }

    public function test_setId()
    {
        $struct = $this->generateStruct();
        $struct->setId('bbc37047d64e0b74787bf4b9a49364aa79c1542b118742feff6a92458a2c1c7f');

        $this->assertEquals('bbc37047d64e0b74787bf4b9a49364aa79c1542b118742feff6a92458a2c1c7f', $struct->getId());
    }

    public function test_getAmount()
    {
        $struct = $this->generateStruct([
            'amount' => 13.3768
        ]);

        $this->assertEquals(13.3768, $struct->getAmount());
    }

    public function test_setAmount()
    {
        $struct = $this->generateStruct();
        $struct->setAmount(1234.75846391);

        $this->assertEquals(1234.75846391, $struct->getAmount());
    }

    public function test_getRecipient()
    {
        $struct = $this->generateStruct([
            'recipient' => 'AHchW9xXpcF85P9MpsMBVv5WMcBrTEdAr9'
        ]);

        $this->assertEquals('AHchW9xXpcF85P9MpsMBVv5WMcBrTEdAr9', $struct->getRecipient());
    }

    public function test_setRecipient()
    {
        $struct = $this->generateStruct();
        $struct->setRecipient('ARuz7iftMcU8GbWC3EHYg5FegA3HwELqsb');

        $this->assertEquals('ARuz7iftMcU8GbWC3EHYg5FegA3HwELqsb', $struct->getRecipient());
    }

    public function test_getVendorField()
    {
        $struct = $this->generateStruct([
            'vendorField' => 'Swark VendorField Get Test'
        ]);

        $this->assertEquals('Swark VendorField Get Test', $struct->getVendorField());
    }

    public function test_setVendorField()
    {
        $struct = $this->generateStruct();
        $struct->setVendorField('Swark VendorField Set Test');

        $this->assertEquals('Swark VendorField Set Test', $struct->getVendorField());
    }

    public function test_getConfirmations()
    {
        $struct = $this->generateStruct([
            'confirmations' => 51
        ]);

        $this->assertEquals(51, $struct->getConfirmations());
    }

    public function test_setConfirmations()
    {
        $struct = $this->generateStruct();
        $struct->setConfirmations(689371031);

        $this->assertEquals(689371031, $struct->getConfirmations());
    }

    public function test_getTimestamp()
    {
        $struct = $this->generateStruct([
            'timestamp' => $this->generateTimestampStruct(['unix' => 1552217275])
        ]);

        $this->assertInstanceOf(TimestampStruct::class, $struct->getTimestamp());
    }

    public function test_setTimestamp()
    {
        $struct = $this->generateStruct();
        $struct->setTimestamp($this->generateTimestampStruct(['unix' => 1552217906]));

        $this->assertInstanceOf(TimestampStruct::class, $struct->getTimestamp());
    }

    public function test_toArray()
    {
        $struct = $this->generateStruct();
        $data = $struct->toArray();

        $this->assertEquals('e1b7b3075355577c8163197d1ce6adac1bffe44b200202b871da6ed16d4f73fc', $data['id']);
        $this->assertEquals(0.00000001, $data['amount']);
        $this->assertEquals('AUDud8tvyVZa67p3QY7XPRUTjRGnWQQ9Xv', $data['recipient']);
        $this->assertEquals('Test', $data['vendorField']);
        $this->assertEquals(51, $data['confirmations']);
        $this->assertEquals(1549798089, $data['timestamp']);
    }

    /**
     * @param array $custom
     *
     * @return TransactionStruct
     */
    private function generateStruct(array $custom = []): TransactionStruct
    {
        $data = [
            'id' => 'e1b7b3075355577c8163197d1ce6adac1bffe44b200202b871da6ed16d4f73fc',
            'amount' => 0.00000001,
            'recipient' => 'AUDud8tvyVZa67p3QY7XPRUTjRGnWQQ9Xv',
            'vendorField' => 'Test',
            'confirmations' => 51,
            'timestamp' => $this->generateTimestampStruct()
        ];

        $data = array_merge($data, $custom);

        return new TransactionStruct(
            $data['id'],
            $data['amount'],
            $data['recipient'],
            $data['vendorField'],
            $data['confirmations'],
            $data['timestamp']
        );
    }

    /**
     * @param array $custom
     *
     * @return TimestampStruct
     */
    private function generateTimestampStruct(array $custom = []): TimestampStruct
    {
        $data = [
            'epoch' => 1549798089,
            'unix' => 1549798089,
            'human' => 'Sunday, 10. February 2019 11:28:09'
        ];

        $data = array_merge($data, $custom);

        return new TimestampStruct(
            $data['epoch'],
            $data['unix'],
            $data['human']
        );
    }
}
