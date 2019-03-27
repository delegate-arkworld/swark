<?php

namespace Swark\Component\ArkClient;

use InvalidArgumentException;

/**
 * Class ConnectionManager
 */
class ConnectionManager
{
    /**
     * @var string
     */
    private $default = 'main';

    /**
     * @var array
     */
    private $connections = [];

    /**
     * @param array  $config
     * @param string $name
     *
     * @return Connection
     */
    public function connect(array $config, string $name = 'main'): Connection
    {
        if (isset($this->connections[$name])) {
            throw new InvalidArgumentException("Connection [$name] is already configured.");
        }

        $this->connections[$name] = new Connection($config);

        return $this->connections[$name];
    }

    /**
     * @param string|null $name
     */
    public function disconnect(string $name = null): void
    {
        $name = $name ?? $this->getDefaultConnection();

        unset($this->connections[$name]);
    }

    /**
     * @param string|null $name
     *
     * @return Connection
     */
    public function connection(string $name = null): Connection
    {
        $name = $name ?? $this->getDefaultConnection();

        if (!isset($this->connections[$name])) {
            throw new InvalidArgumentException("Connection [$name] not configured.");
        }

        return $this->connections[$name];
    }

    /**
     * @return string
     */
    public function getDefaultConnection(): string
    {
        return $this->default;
    }

    /**
     * @param string $name
     */
    public function setDefaultConnection(string $name): void
    {
        $this->default = $name;
    }

    /**
     * @return array
     */
    public function getConnections(): array
    {
        return $this->connections;
    }
}
