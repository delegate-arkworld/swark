<?php

namespace Swark\Subscriber;

use Swark\Services\OrderService;

/**
 * Class TransactionsCronSubscriber
 */
class TransactionsCronSubscriber
{
    /**
     * @var OrderService
     */
    private $orderService;

    /**
     * @param OrderService $orderService
     */
    public function __construct(
        OrderService $orderService
    ) {
        $this->orderService = $orderService;
    }

    /**
     * {@inheritdoc}
     */
    public function onRunCronjob()
    {
        try {
            $this->orderService->checkTransactions();
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        return true;
    }
}
