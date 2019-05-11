<?php

namespace Swark\Decorator;

use Shopware\Components\DependencyInjection\Container as ContainerAlias;
use Shopware\Components\Model\ModelRepository;
use Shopware\Models\Shop\Currency;
use Zend_Currency;
use Zend_Currency_Exception;
use Zend_Locale;

/**
 * Class CurrencyFactoryDecorator
 */
class CurrencyFactoryDecorator
{
    /**
     * @param ContainerAlias $container
     * @param Zend_Locale    $locale
     *
     * @throws Zend_Currency_Exception
     *
     * @return Zend_Currency
     */
    public function factory(ContainerAlias $container, Zend_Locale $locale)
    {
        $request = $container->get('Front');
        $currencyId = $request->Request()->getCookie('currency');

        $repository = $this->getCurrencyRepository($container);

        /** @var Currency $currency */
        $currency = $repository->findOneBy([
            'id' => $currencyId,
        ]);

        if ($currency && $currency->getCurrency() === 'ARK') {
            $pluginConfig = $this->getPluginConfig($container);

            $currency = [
                'precision' => $pluginConfig['precision'],
                'currency' => 'ARK',
            ];
        } else {
            $currency = $this->getDefaultCurrency($container);
        }

        return new Zend_Currency($currency, $locale);
    }

    /**
     * @param ContainerAlias $container
     *
     * @return string
     */
    private function getDefaultCurrency(ContainerAlias $container): string
    {
        $repository = $this->getCurrencyRepository($container);

        /** @var Currency $defaultCurrency */
        $defaultCurrency = $repository->findOneBy([
            'default' => true,
        ]);

        return $defaultCurrency->getCurrency();
    }

    /**
     * @param ContainerAlias $container
     *
     * @return ModelRepository
     */
    private function getCurrencyRepository(ContainerAlias $container): ModelRepository
    {
        return $container->get('models')->getRepository(Currency::class);
    }

    /**
     * @param ContainerAlias $container
     *
     * @return array
     */
    private function getPluginConfig(ContainerAlias $container): array
    {
        return $container->get('swark.config');
    }
}
