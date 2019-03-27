<?php

namespace Swark;

use Doctrine\ORM\OptimisticLockException;
use Exception;
use Shopware\Bundle\AttributeBundle\Service\CrudService;
use Shopware\Components\HttpClient\RequestException;
use Shopware\Components\Logger;
use Shopware\Components\Model\ModelManager;
use Shopware\Components\Plugin;
use Shopware\Components\Plugin\Context\InstallContext;
use Shopware\Components\Plugin\PaymentInstaller;
use Shopware\Models\Shop\Currency;

/**
 * Class Swark
 *
 * @package Swark
 */
class Swark extends Plugin
{
    /**
     * @param InstallContext $context
     *
     * @throws Exception
     */
    public function install(InstallContext $context)
    {
        parent::install($context);

        $this->installCurrency();
        $this->createOrUpdateAttributes();
        $this->installPayment();
    }

    /**
     * @throws Exception
     */
    protected function createOrUpdateAttributes()
    {
        /**
         * @var CrudService
         */
        $service = $this->container->get('shopware_attribute.crud_service');

        $service->update(
            's_order_attributes',
            'swark_recipient_address',
            'string',
            [
                'label' => '[Swark] Recipient Address',
                'supportText' => '',
                'helpText' => '',
                'displayInBackend' => true,
            ]
        );

        $service->update(
            's_order_attributes',
            'swark_transaction_id',
            'string',
            [
                'label' => '[Swark] TransactionId',
                'supportText' => '',
                'helpText' => '',
                'displayInBackend' => true,
            ]
        );

        $service->update(
            's_order_attributes',
            'swark_ark_amount',
            'float',
            [
                'label' => '[Swark] ARK amount',
                'supportText' => '',
                'helpText' => '',
                'displayInBackend' => true,
            ]
        );

        $service->update(
            's_order_attributes',
            'swark_vendor_field',
            'string',
            [
                'label' => '[Swark] Vendorfield',
                'supportText' => '',
                'helpText' => '',
                'displayInBackend' => true,
            ]
        );

        $service->update(
            's_order_attributes',
            'swark_transaction_id',
            'string',
            [
                'label' => '[Swark] Transaction Id',
                'supportText' => '',
                'helpText' => '',
                'displayInBackend' => true,
            ]
        );

        $models = $this->container->get('models');
        $metaDataCache = $models->getConfiguration()->getMetadataCacheImpl();
        $metaDataCache->deleteAll();
        $models->generateAttributeModels(['s_order_attributes']);
    }

    /**
     * Create or update the payment method
     */
    protected function installPayment(): void
    {
        /** @var PaymentInstaller $installer */
        $installer = $this->container->get('shopware.plugin_payment_installer');

        $options = [
            'name' => 'ark',
            'description' => 'Ark',
            'template' => '',
            'active' => 0,
            'position' => 0,
            'additionalDescription' => '<img src="data:image/png;base64,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"/>'
                . '<div id="payment_desc">'
                . '  Pay safe and secure with Ark.'
                . '</div>',
        ];

        $installer->createOrUpdate($this->getName(), $options);
    }

    /**
     * @throws RequestException
     * @throws OptimisticLockException
     */
    protected function installCurrency(): void
    {
        // TODO: Also needs some frontend changes for display of arktoshis
        // plan: Register modifier currency modifier on frontend and check there if currency is Ark (Set precision on 8)

        /** @var ModelManager $models */
        $models = $this->container->get('models');

        /** @var Currency $currency */
        $currency = $models->getRepository(Currency::class)->findOneBy([
            'currency' => 'ARK',
        ]);

        if ($currency) {
            return;
        }

        $currency = new Currency();

        $currency
            ->setCurrency('ARK')
            ->setName('Ark')
            ->setFactor($this->getCurrencyFactor())
            ->setSymbol('Ѧ')
            ->setSymbolPosition(16);

        $models->persist($currency);
        $models->flush($currency);
    }

    /**
     * @throws RequestException
     *
     * @return float
     */
    protected function getCurrencyFactor(): float
    {
        /** @var ModelManager $models */
        $models = $this->container->get('models');

        $exchangeService = new \Swark\Service\ExchangeService(
            $this->container->get('http_client'),
            new Logger('error'),
            new Logger('process'),
            $models
        );

        /** @var Currency $currency */
        $currency = $models->getRepository(Currency::class)->findOneBy([
            'default' => true,
        ]);

        return $exchangeService->getExchangeRate($currency->getCurrency());
    }

    /**
     * @return array|mixed
     */
    protected function getPluginConfiguration()
    {
        /** @var Plugin\CachedConfigReader $configReader */
        $configReader = $this->container->get('shopware.plugin.cached_config_reader');

        return $configReader->getByPluginName('swark');
    }
}
