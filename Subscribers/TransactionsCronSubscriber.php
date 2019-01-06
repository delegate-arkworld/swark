<?php

namespace Swark\Subscribers;

use Swark\Components\Services\OrderService;

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
     * TransactionsCronSubscriber constructor.
     *
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