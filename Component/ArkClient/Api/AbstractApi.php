<?php

namespace Swark\Component\ArkClient\Api;

use Swark\Component\ArkClient\Connection;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

/**
 * Class AbstractAPI
 */
abstract class AbstractApi
{
    /**
     * @var Connection
     */
    public $connection;

    /**
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param string $method
     * @param string $path
     * @param array  $params
     *
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     *
     * @return array|string
     */
    protected function query(string $method, string $path, array $params = [])
    {
        $response = $this->connection->getHttpClient()->request($method, $path, ['json' => $params]);

        return json_decode($response->getContent(), true);
    }
}
