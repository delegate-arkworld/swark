<?php

namespace Swark\Subscriber;

use Swark\Services\OrderService;

/**
 * Class SaveOrderSubscriber
 */
class SaveOrderSubscriber
{
    /**
     * @var OrderService
     */
    private $orderService;

    /**
     * SaveOrderSubscriber constructor.
     *
     * @param OrderService $orderService
     */
    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * @param \Enlight_Event_EventArgs $args
     * @throws \Exception
     */
    public function onOrderSaveOrderProcessDetails(\Enlight_Event_EventArgs $args): void
    {
        // TODO: get Payment Object

        //if (!$this->orderService->checkPayment()) {
        //    return;
        //}

        $order = $args->getSubject();
        $orderNumber = $order->sOrderNumber;

        $this->orderService->processOrder($orderNumber);
    }
}
