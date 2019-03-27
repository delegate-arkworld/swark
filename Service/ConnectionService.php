<?php

namespace Swark\Service;

use Swark\Component\ArkClient\ConnectionManager;

if (file_exists(__DIR__ . '/../vendor/autoload.php')) {
    require_once __DIR__ . '/../vendor/autoload.php';
}

/**
 * Class ConnectionService
 */
class ConnectionService
{
    /**
     * @var array
     */
    private $pluginConfig;

    /**
     * @param array $pluginConfig
     */
    public function __construct(array $pluginConfig)
    {
        $this->pluginConfig = $pluginConfig;
    }

    /**
     * @return ConnectionManager
     */
    public function getConnectionManager(): ConnectionManager
    {
        $manager = new ConnectionManager();

        $manager->connect([
            'host' => $this->pluginConfig['mainNodeApi'],
        ], 'main');

        $manager->connect([
            'host' => $this->pluginConfig['backupNodeApi'],
        ], 'backup');

        return $manager;
    }
}
