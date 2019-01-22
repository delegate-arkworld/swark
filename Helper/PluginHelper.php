<?php

namespace Swark\Helper;

use Shopware\Models\Plugin\Plugin;
use Shopware\Components\Model\ModelManager;

/**
 * Class PluginHelper
 */
class PluginHelper
{
    /**
     * @var string
     */
    private $pluginName;

    /**
     * @var ModelManager
     */
    private $models;

    /**
     * @var array
     */
    private $pluginConfig;

    /**
     * PluginHelper constructor.
     *
     * @param string $pluginName
     * @param ModelManager $models
     * @param array $pluginConfig
     */
    public function __construct(
        string $pluginName,
        ModelManager $models,
        array $pluginConfig
    ) {
        $this->pluginName = $pluginName;
        $this->models = $models;
        $this->pluginConfig = $pluginConfig;
    }

    /**
     * @return int
     */
    public function getPluginId(): int
    {
        return $this->getPluginObject()->getId();
    }

    /**
     * @return Object|Plugin
     */
    public function getPluginObject(): Plugin
    {
        return $this->models->getRepository(Plugin::class)->findOneBy(
            [
                'name' => $this->pluginName
            ]
        );
    }

    /**
     * @param int $pluginId
     * @return bool
     */
    public function checkPlugin(int $pluginId): bool
    {
        return $this->getPluginId() === $pluginId;
    }

    /**
     * @return array
     */
    public function getWalletsByConfig(): array
    {
        return \explode(';', $this->pluginConfig['wallets']);
    }

    /**
     * @return string
     */
    public function getRandomWallet(): string
    {
        $data = $this->getWalletsByConfig();

        return $data[\array_rand($data)];
    }
}
