<?php

namespace Swark\Decorator;

use Shopware\Components\DependencyInjection\Container as ContainerAlias;
use Zend_Currency;
use Zend_Currency_Exception;
use Zend_Locale;

/**
 * Class CurrencyFactoryDecorator
 *
 * @package Swark\Decorator
 */
class CurrencyFactoryDecorator
{
    /**
     * @param ContainerAlias $container
     * @param Zend_Locale $locale
     *
     * @return Zend_Currency
     *
     * @throws Zend_Currency_Exception
     */
    public function factory(ContainerAlias $container, Zend_Locale $locale)
    {
        $currency = 'EUR';

        if ($container->has('Shop')) {
            $currency = $container->get('Shop')->getCurrency()->getCurrency();
        }

        // TODO: check if currency is ARK

        echo "<pre>";
        \Doctrine\Common\Util\Debug::dump('test');
        exit;

        if ($currency === 'ARK') {
            $currency = [
                'precision' => 8,
                'currency' => $currency
            ];
        }

        //var_dump($currency); exit;

        return new Zend_Currency($currency, $locale);
    }
}
