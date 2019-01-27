<?php

namespace Swark\Tests\Unit\Subscriber;

use Shopware\Components\Test\Plugin\TestCase;
use Swark\Structs\Timestamp;

/**
 * Class TimestampStructTest
 */
class TimestampStructTest extends TestCase
{
    protected static $ensureLoadedPlugins = [
        'Swark' => [],
    ];

    public function test_construction()
    {
        $struct = new Timestamp(
            0,
            0,
            'human'
        );

        $this->assertInstanceOf(Timestamp::class, $struct);
    }
}
