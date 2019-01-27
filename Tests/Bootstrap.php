<?php

require __DIR__ . '/../../../../autoload.php';

use Shopware\Models\Shop\Shop;

/**
 * Class SwarkTestKernel
 */
class SwarkTestKernel extends \Shopware\Kernel
{
    /**
     * @throws Exception
     */
    public static function start(): void
    {
        $kernel = new self(\getenv('SHOPWARE_ENV') ?: 'testing', true);
        $kernel->boot();

        $container = $kernel->getContainer();
        $container->get('plugins')->Core()->ErrorHandler()->registerErrorHandler(E_ALL | E_STRICT);

        /** @var $repository \Shopware\Models\Shop\Repository */
        $repository = $container->get('models')->getRepository(Shop::class);

        $shop = $repository->getActiveDefault();
        $shop->registerResources();

        $_SERVER['HTTP_HOST'] = $shop->getHost();

        if (!self::isPluginInstalledAndActivated($container)) {
            die('Error: The plugin is not installed or activated, tests aborted!');
        }

        $container->get('loader')->registerNamespace('Swark', __DIR__ . '/../');
    }

    /**
     * @param $container
     *
     * @return bool
     */
    private static function isPluginInstalledAndActivated($container): bool
    {
        /** @var \Doctrine\DBAL\Connection $db */
        $db = $container->get('dbal_connection');

        $sql = "SELECT active FROM s_core_plugins WHERE name = 'Swark'";
        $active = $db->fetchColumn($sql);

        return (bool) $active;
    }
}

SwarkTestKernel::start();
