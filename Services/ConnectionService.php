<?php

namespace Swark\Services;

use ArkEcosystem\Client\ConnectionManager;

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

        // TODO: remove line before release!
        // for testing: http://167.114.43.40:4003/api/v2

        $manager->connect([
            'host' => $this->pluginConfig['mainNodeApi'],
            'version' => 2
        ], 'main');

        $manager->connect([
            'host' => $this->pluginConfig['backupNodeApi'],
            'version' => 2
        ], 'backup');

        return $manager;
    }
}
