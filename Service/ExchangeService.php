<?php

namespace Swark\Service;

use Shopware\Components\HttpClient\GuzzleHttpClient;
use Shopware\Components\HttpClient\RequestException;
use Shopware\Components\HttpClient\Response;
use Shopware\Components\Model\ModelManager;
use Shopware\Models\Shop\Currency;

/**
 * Class ExchangeService
 */
class ExchangeService
{
    const URL = 'https://min-api.cryptocompare.com/data/price?fsym=ARK&tsyms=';

    /**
     * @var GuzzleHttpClient
     */
    private $client;

    /**
     * @var LoggerService
     */
    private $loggerService;

    /**
     * @var ModelManager
     */
    private $models;

    /**
     * @param GuzzleHttpClient $client
     * @param LoggerService    $loggerService
     * @param ModelManager     $modelManager
     */
    public function __construct(
        GuzzleHttpClient $client,
        LoggerService $loggerService,
        ModelManager $modelManager
    ) {
        $this->client = $client;
        $this->loggerService = $loggerService;
        $this->models = $modelManager;
    }

    /**
     * @param string $currency
     *
     * @throws RequestException
     * @throws \Exception
     *
     * @return bool
     */
    public function updateExchangeRate(string $currency = 'EUR'): bool
    {
        $rate = $this->getExchangeRate($currency);

        if (!$rate) {
            return false;
        }

        try {
            /** @var Currency $object */
            $object = $this->models->getRepository(Currency::class)->findBy([
                'currency' => 'ARK',
            ]);

            $object->setFactor($rate);

            $this->models->persist($object);
            $this->models->flush($object);
        } catch (\Exception $e) {
            $this->loggerService->error('Could not update Ark currency factor', $e->getTrace());
            throw $e;
        }

        $this->loggerService->info('Updated the Ark currency factor to ' . $rate);

        return true;
    }

    /**
     * @param string $currency
     *
     * @throws RequestException
     *
     * @return float
     */
    public function getExchangeRate(string $currency): float
    {
        try {
            /** @var Response $result */
            $result = $this->client->get(self::URL . $currency);
        } catch (RequestException $e) {
            $this->loggerService->error('Could not get the exchange rate from the external api!', $e->getTrace());
            throw $e;
        }

        if ($result->getStatusCode() === 200) {
            return \json_decode($result->getBody())->{$currency};
        }

        $this->loggerService->error('Exchange rate status code is not 200!', []);

        return false;
    }
}
