<?php

namespace Swark\Subscriber;

use Swark\Services\OrderService;
use Enlight\Event\SubscriberInterface;

/**
 * Class TransactionsCronSubscriber
 */
class TransactionsCronSubscriber implements SubscriberInterface
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
    public static function getSubscribedEvents()
    {
        return [
            'Shopware_CronJob_SwarkCheckTransactions' => 'onRunCronjob',
        ];
    }

    /**
     * @return bool|string
     */
    public function onRunCronjob()
    {
        try {
            $success = $this->orderService->checkTransactions();
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        if (!$success) {
            return 'No open orders!';
        }

        return true;
    }
}
