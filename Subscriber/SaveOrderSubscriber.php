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
     * @param OrderService $orderService
     */
    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * @param \Enlight_Event_EventArgs $args
     *
     * @throws \Exception
     */
    public function onOrderSaveOrderProcessDetails(\Enlight_Event_EventArgs $args): void
    {
        /** @var \sOrder $order */
        $order = $args->getSubject();

        if (!empty($order->sUserData['additional']['payment']['id'])) {
            $paymentId = $order->sUserData['additional']['payment']['id'];
        } else {
            $paymentId = $order->sUserData['additional']['user']['paymentID'];
        }

        if (!$this->orderService->checkPayment((int) $paymentId['id'])) {
            return;
        }

        $this->orderService->processOrder($order->sOrderNumber);
    }
}
