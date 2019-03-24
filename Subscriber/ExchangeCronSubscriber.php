<?php

namespace Swark\Subscriber;

use Swark\Service\ExchangeService;
use Enlight\Event\SubscriberInterface;

/**
 * Class ExchangeCronSubscriber
 */
class ExchangeCronSubscriber implements SubscriberInterface
{
    /**
     * @var ExchangeService
     */
    private $exchangeService;

    /**
     * @param ExchangeService $exchangeService
     */
    public function __construct(
        ExchangeService $exchangeService
    ) {
        $this->exchangeService = $exchangeService;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            'Shopware_CronJob_SwarkUpdateExchangeRate' => 'onRunCronjob',
        ];
    }

    /**
     * @return bool|string
     */
    public function onRunCronjob()
    {
        try {
            $this->exchangeService->updateExchangeRate();
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        return true;
    }
}
