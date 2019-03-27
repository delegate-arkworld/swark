<?php

namespace Swark\Component\ArkClient\Api;

use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

/**
 * Class Transactions
 *
 * @package Swark\Component\ArkClient\Api
 */
class Transactions extends AbstractApi
{
    /**
     * @param array $params
     *
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     *
     * @return array
     */
    public function all(array $params = []): array
    {
        return $this->query('GET', 'transactions', $params);
    }

    /**
     * @param string $id
     *
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     *
     * @return array
     */
    public function show(string $id): array
    {
        return $this->query('GET', "transactions/{$id}");
    }

    /**
     * @param array $params
     *
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     *
     * @return array
     */
    public function search(array $params): array
    {
        return $this->query('POST', 'transactions/search', $params);
    }
}
