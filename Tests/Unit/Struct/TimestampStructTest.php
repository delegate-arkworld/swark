<?php

namespace Swark\Tests\Unit\Struct;

use Shopware\Components\Test\Plugin\TestCase;
use Swark\Struct\TimestampStruct;

/**
 * Class TimestampStructTest
 *
 * @package Swark\Tests\Unit\Struct
 */
class TimestampStructTest extends TestCase
{
    protected static $ensureLoadedPlugins = [
        'Swark' => [],
    ];

    public function test_construction()
    {
        $struct = $this->generateStruct();

        $this->assertInstanceOf(TimestampStruct::class, $struct);
    }

    public function test_getEpoch()
    {
        $struct = $this->generateStruct([
            'epoch' => 1549797501
        ]);

        $this->assertEquals(1549797501, $struct->getEpoch());
    }

    public function test_setEpoch()
    {
        $struct = $this->generateStruct();
        $struct->setEpoch(1549797521);

        $this->assertEquals(1549797521, $struct->getEpoch());
    }

    public function test_getUnix()
    {
        $struct = $this->generateStruct([
            'unix' => 1549797543
        ]);

        $this->assertEquals(1549797543, $struct->getUnix());
    }

    public function test_setUnix()
    {
        $struct = $this->generateStruct();
        $struct->setUnix(1549797557);

        $this->assertEquals(1549797557, $struct->getUnix());
    }

    public function test_getHuman()
    {
        $struct = $this->generateStruct([
            'human' => 'Sunday, 10. February 2019 11:19:50'
        ]);

        $this->assertEquals('Sunday, 10. February 2019 11:19:50', $struct->getHuman());
    }

    public function test_setHuman()
    {
        $struct = $this->generateStruct();
        $struct->setHuman('Sunday, 10. February 2019 11:20:20');

        $this->assertEquals('Sunday, 10. February 2019 11:20:20', $struct->getHuman());
    }

    public function test_toArray()
    {
        $struct = $this->generateStruct();
        $data = $struct->toArray();

        $this->assertEquals(1549797099, $data['epoch']);
        $this->assertEquals(1549797099, $data['unix']);
        $this->assertEquals('Sunday, 10. February 2019 11:11:39', $data['human']);
    }

    /**
     * @param array $custom
     *
     * @return TimestampStruct
     */
    private function generateStruct(array $custom = []): TimestampStruct
    {
        $data = [
            'epoch' => 1549797099,
            'unix' => 1549797099,
            'human' => 'Sunday, 10. February 2019 11:11:39',
        ];

        $data = array_merge($data, $custom);

        return new TimestampStruct(
            $data['epoch'],
            $data['unix'],
            $data['human']
        );
    }
}
