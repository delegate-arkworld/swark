<?php

namespace Swark\Helper;

use Shopware\Components\Model\ModelManager;
use Shopware\Models\Order\Order;
use Shopware\Models\Order\Status;
use Shopware\Models\Payment\Payment;
use Shopware\Models\Shop\Currency;
use Swark\Structs\Attributes;

/**
 * Class OrderHelper
 */
class OrderHelper
{
    /**
     * @var ModelManager
     */
    private $models;

    /**
     * @var PluginHelper
     */
    private $pluginHelper;

    /**
     * @var array
     */
    private $pluginConfig;

    /**
     * @param ModelManager $models
     * @param PluginHelper $pluginHelper
     * @param array        $config
     */
    public function __construct(
        ModelManager $models,
        PluginHelper $pluginHelper,
        array $config
    ) {
        $this->models = $models;
        $this->pluginHelper = $pluginHelper;
        $this->pluginConfig = $config;
    }

    /**
     * @return array
     */
    public function getOrders(): array
    {
        return $this->models->getRepository(Order::class)->findBy(
            [
                'payment' => $this->getPaymentObject(),
            ]
        );
    }

    /**
     * @param int $orderNumber
     *
     * @return object|Order
     */
    public function getOrder(int $orderNumber): Order
    {
        return $this->models->getRepository(Order::class)->findOneBy(
            [
                'number' => $orderNumber,
            ]
        );
    }

    /**
     * @return array
     */
    public function getOpenOrders(): array
    {
        return $this->models->getRepository(Order::class)->findBy([
            'payment' => $this->getPaymentObject()->getId(),
            'cleared' => Status::PAYMENT_STATE_OPEN
        ]);
    }

    /**
     * @return object|Payment
     */
    public function getPaymentObject(): Payment
    {
        return $this->models->getRepository(Payment::class)->findOneBy(
            [
                'plugin' => $this->pluginHelper->getPluginObject(),
            ]
        );
    }

    /**
     * @return array
     */
    public function getClosedOrders(): array
    {
        $qb = $this->models->getRepository(Order::class)->createQueryBuilder('o');

        $qb->select('o')
            ->where('o.paymentStatus = :paymentStatus')
            ->setParameter('paymentStatus', $this->getPaymentStatus());

        return $qb->getQuery()->getResult();
    }

    /**
     * @param \Shopware\Models\Attribute\Order $attributes
     *
     * @return array
     */
    public function getOrderAttributes(\Shopware\Models\Attribute\Order $attributes): array
    {
        $struct = new Attributes(
            $attributes->getSwarkTransactionId(),
            $attributes->getSwarkArkAmount(),
            $attributes->getSwarkRecipientAddress(),
            $attributes->getSwarkVendorField()
        );

        return $struct->toArray();
    }

    /**
     * @param Order $order
     *
     * @return
     */
    public function getAmountByOrder(Order $order)
    {
        return $order->getAttribute()->getSwarkArkAmount();
    }

    /**
     * @param Order $order
     *
     * @return
     */
    public function getRecipientAddressByOrder(Order $order)
    {
        return $order->getAttribute()->getSwarkRecipientAddress();
    }

    /**
     * @param Order $order
     *
     * @return
     */
    public function getVendorFieldByOrder(Order $order)
    {
        return $order->getAttribute()->getSwarkVendorField();
    }

    /**
     * @param Order $order
     *
     * @return
     */
    public function getTransactionIdByOrder(Order $order)
    {
        return $order->getAttribute()->getSwarkTransactionId();
    }

    /**
     * @return Status
     */
    public function getPaymentStatus(): Status
    {
        /** @var Status $object */
        $object = $this->models->getRepository(Status::class)->find($this->pluginConfig['paymentStatus']);

        return $object;
    }

    /**
     * @param int $orderNumber
     *
     * @return string
     */
    public function getVendorFieldLayout(int $orderNumber): string
    {
        return \str_replace('{$ordernumber}', $orderNumber, $this->pluginConfig['vendorField']);
    }

    /**
     * @return Currency
     */
    public function getDefaultCurrency(): Currency
    {
        /** @var Currency $currency */
        $currency = $this->models->getRepository(Currency::class)->findOneBy([
            'default' => true,
        ]);

        return $currency;
    }

    /**
     * @return float
     */
    public function getArkCurrencyFactor(): float
    {
        /** @var Currency $currency */
        $currency = $this->models->getRepository(Currency::class)->findOneBy([
            'currency' => 'ARK'
        ]);

        return $currency->getFactor();
    }
}
