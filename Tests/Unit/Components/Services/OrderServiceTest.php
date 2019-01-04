<?php

namespace Swark\Tests\Unit\Components\Services;

use Shopware\Components\Test\Plugin\TestCase;
use Swark\Components\Services\OrderService;

/**
 * Class OrderServiceTest
 */
class OrderServiceTest extends TestCase
{
    /**
     * @var OrderService $service
     */
    private $service;

    protected function setUp()
    {
        parent::setUp();

        $this->service = Shopware()->Container()->get('swark.components.services.order_service');
    }

    protected static $ensureLoadedPlugins = [
        'Swark' => []
    ];

}