<?php

namespace Swark\Tests\Unit\Subscriber;

use Shopware\Components\Test\Plugin\TestCase;
use Swark\Structs\Transaction;
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
        $struct = new Transaction(
            'id',
            0,
            'recipient',
            'vendorField',
            0,
            new TimestampStructMock()
        );

        $this->assertInstanceOf(Transaction::class, $struct);
    }
}
