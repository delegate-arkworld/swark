<?php

namespace Swark\Decorator;

use Shopware\Components\DependencyInjection\Container as ContainerAlias;
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
        $currency = 'EUR';

        if ($container->has('Shop')) {
            $currency = $container->get('Shop')->getCurrency()->getCurrency();
        }

        // TODO: check if current currency is ARK

        if ($currency === 'ARK') {
            $currency = [
                'precision' => 8,
                'currency' => $currency,
            ];
        }

        return new Zend_Currency($currency, $locale);
    }
}
