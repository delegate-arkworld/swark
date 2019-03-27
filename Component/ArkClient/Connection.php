<?php

namespace Swark\Component\ArkClient;

use Exception;
use RuntimeException;
use Swark\Component\ArkClient\Api\AbstractAPI;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * Class Connection
 *
 * @package Swark\Component\ArkClient
 */
class Connection
{
    /**
     * @var HttpClientInterface
     */
    public $httpClient;

    /**
     * @param array $config
     */
    public function __construct(array $config)
    {
        $options = [
            'base_uri' => $config['host'],
            'headers' => [
                'Content-Type' => 'application/json',
                'API-Version' => 2,
            ],
        ];

        $this->httpClient = (new HttpClient())->create($options);
    }

    /**
     * @param string $name
     * @param mixed  $args
     *
     * @throws Exception
     *
     * @return AbstractApi
     */
    public function __call($name, $args)
    {
        try {
            return $this->api($name);
        } catch (Exception $e) {
            throw new Exception(sprintf('Undefined method called: "%s"', $name));
        }
    }

    /**
     * @param string $name
     *
     * @return AbstractAPI
     */
    public function api(string $name): AbstractApi
    {
        $name = ucfirst($name);
        $class = "Swark\\Components\\ArkClient\\Api\\{$name}";

        if (! class_exists($class)) {
            throw new RuntimeException("Class [$class] does not exist.");
        }

        return new $class($this);
    }

    /**
     * @return HttpClientInterface
     */
    public function getHttpClient(): HttpClientInterface
    {
        return $this->httpClient;
    }
}
