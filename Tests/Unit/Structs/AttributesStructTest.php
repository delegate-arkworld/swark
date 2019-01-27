<?php

namespace Swark\Tests\Unit\Subscriber;

use Shopware\Components\Test\Plugin\TestCase;
use Swark\Structs\Attributes;

/**
 * Class AttributesStructTest
 */
class AttributesStructTest extends TestCase
{
    protected static $ensureLoadedPlugins = [
        'Swark' => []
    ];

    public function test_construction()
    {
        $struct = new Attributes(
            'transactionId',
            0.00,
            'recipient',
            'vendorField'
        );

        $this->assertInstanceOf(Attributes::class, $struct);
    }
}
