<?php

namespace Swark\Subscriber;

use Swark\Services\ExchangeService;

/**
 * Class ExchangeCronSubscriber
 */
class ExchangeCronSubscriber
{
    /**
     * @var ExchangeService
     */
    private $exchangeService;

    /**
     * ExchangeCronSubscriber constructor.
     *
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
