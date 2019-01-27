<?php

namespace Swark\Services;

use Shopware\Components\Model\ModelManager;
use Shopware\Models\Order\Order;
use Swark\Helper\OrderHelper;
use Swark\Helper\PluginHelper;

/**
 * Class OrderService
 */
class OrderService
{
    /**
     * @var ModelManager
     */
    private $models;

    /**
     * @var OrderHelper
     */
    private $orderHelper;

    /**
     * @var PluginHelper
     */
    private $pluginHelper;

    /**
     * @var TransactionService
     */
    private $transactionService;

    /**
     * @var array
     */
    private $pluginConfig;

    /**
     * @var LoggerService
     */
    private $loggerService;

    /**
     * @param ModelManager       $models
     * @param OrderHelper        $orderHelper
     * @param PluginHelper       $pluginHelper
     * @param TransactionService $transactionService
     * @param array              $pluginConfig
     * @param LoggerService      $loggerService
     */
    public function __construct(
        ModelManager $models,
        OrderHelper $orderHelper,
        PluginHelper $pluginHelper,
        TransactionService $transactionService,
        array $pluginConfig,
        LoggerService $loggerService
    ) {
        $this->models = $models;
        $this->orderHelper = $orderHelper;
        $this->pluginHelper = $pluginHelper;
        $this->transactionService = $transactionService;
        $this->pluginConfig = $pluginConfig;
        $this->loggerService = $loggerService;
    }

    /**
     * Function to check the transactions
     *
     * @throws \RuntimeException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Exception
     */
    public function checkTransactions(): bool
    {
        $orders = $this->orderHelper->getOpenOrders();

        if (!$orders) {
            $this->loggerService->notify(
                'No open orders found.'
            );
            return false;
        }

        /**
         * @var Order $order
         */
        foreach ($orders as $order) {
            $this->loggerService->notify(
                'Processing Order [' . $order->getNumber() . ']'
            );
            $attributes = $this->orderHelper->getOrderAttributes($order->getAttribute());

            $transaction = $this->transactionService->getTransaction(
                $attributes['swarkRecipientAddress'],
                $attributes['swarkVendorField']
            );

            if ($transaction) {
                $this->updateOrderTransactionId($order->getAttribute(), $transaction->getId(), $order->getNumber());

                if (!$this->checkConfirmations($transaction->getConfirmations())) {
                    $this->loggerService->notify(
                        'Order [' . $order->getNumber() . '] need more confirmations. Currently: ' . $transaction->getConfirmations()
                    );
                    continue;
                }

                // TODO: check amount before set to paymentStatus
                $this->updateOrderPaymentStatus($order);

                continue;
            }

            $this->loggerService->warning(
                'No transaction for Order [' . $order->getNumber() . '] found!'
            );
        }

        return true;
    }

    /**
     * @param int $orderNumber
     *
     * @return bool
     * @throws \Exception
     */
    public function processOrder(int $orderNumber): bool
    {
        /** @var Order $order */
        $order = $this->orderHelper->getOrder($orderNumber);
        $attributes = $order->getAttribute();

        $this->updateOrderAmount($order, $attributes);
        $this->updateOrderRecipientAddress($attributes, $orderNumber);
        $this->updateOrderVendorField($attributes, $orderNumber);
        $this->updateOrderTransactionId($attributes, '', $orderNumber);

        return true;
    }

    /**
     * @param \Shopware\Models\Attribute\Order $attributes
     * @param string                           $transactionId
     * @param int                              $orderNumber
     *
     * @throws \Exception
     */
    public function updateOrderTransactionId(\Shopware\Models\Attribute\Order $attributes, string $transactionId, int $orderNumber): void
    {
        try {
            $attributes->setSwarkTransactionId($transactionId);

            $this->models->persist($attributes);
            $this->models->flush($attributes);
        } catch (\Exception $e) {
            $this->loggerService->error('Order transaction id could not be updated!', $e->getTrace());
            throw $e;
        }

        $this->loggerService->notify(
            'Updated transaction id to [' . $transactionId . '] from order [' . $orderNumber . ']'
        );
    }

    /**
     * @param Order                            $order
     * @param \Shopware\Models\Attribute\Order $attributes
     *
     * @throws \Exception
     */
    public function updateOrderAmount(Order $order, \Shopware\Models\Attribute\Order $attributes): void
    {
        try {
            // TODO: Generate Calculate Bundle for different calculation types?
            // TODO: maybe use ARK default calculator and use currency exchange rate? Edegecase: Shop which is using USD

            // TODO: check if currency is ARK and then update the amount from the order
            $amount = $order->getInvoiceAmount();

            $attributes->setSwarkArkAmount($amount);

            $this->models->persist($attributes);
            $this->models->flush($attributes);
        } catch (\Exception $e) {
            $this->loggerService->error('Order amount could not be updated!', $e->getTrace());
            throw $e;
        }

        $this->loggerService->notify(
            'Updated amount to [' . $amount . '] for order [' . $order->getNumber().  ']'
        );
    }

    /**
     * @param \Shopware\Models\Attribute\Order $attributes
     *
     * @param int                              $orderNumber
     *
     * @throws \Exception
     */
    public function updateOrderRecipientAddress(\Shopware\Models\Attribute\Order $attributes, int $orderNumber): void
    {
        try {
            $recipient = $this->pluginHelper->getRandomWallet();

            $attributes->setSwarkRecipientAddress($recipient);

            $this->models->persist($attributes);
            $this->models->flush($attributes);
        } catch (\Exception $e) {
            $this->loggerService->error('Order recipient address could not be updated!', $e->getTrace());
            throw $e;
        }

        $this->loggerService->notify(
            'Updated recipient address to [' . $recipient . '] from order [' . $orderNumber . ']'
        );
    }

    /**
     * @param \Shopware\Models\Attribute\Order $attributes
     * @param int                              $orderNumber
     *
     * @throws \Exception
     */
    public function updateOrderVendorField(\Shopware\Models\Attribute\Order $attributes, int $orderNumber): void
    {
        try {
            $vendorField = $this->orderHelper->getVendorFieldLayout($orderNumber);

            $attributes->setSwarkVendorField($vendorField);

            $this->models->persist($attributes);
            $this->models->flush($attributes);
        } catch (\Exception $e) {
            $this->loggerService->error('Order vendorField could not be updated!', $e->getTrace());
            throw $e;
        }

        $this->loggerService->notify(
            'Updated vendorField to [' . $vendorField . '] from order [' . $orderNumber . ']'
        );
    }

    /**
     * @param Order $order
     *
     * @return bool
     * @throws \Exception
     */
    public function updateOrderPaymentStatus(Order $order): bool
    {
        try {
            $paymentStatus = $this->orderHelper->getPaymentStatus();

            $order->setPaymentStatus($paymentStatus);
            // TODO: check if e-mail will be sent out correctly!
            $this->models->persist($order);
            $this->models->flush($order);
        } catch (\Exception $e) {
            $this->loggerService->error('Order payment status could not be updated!', $e->getTrace());
            throw $e;
        }

        $this->loggerService->notify(
            'Updated order [' . $order->getNumber() . '] and set payment status to [' . $paymentStatus->getName() . ']'
        );

        return true;
    }

    /**
     * @param int $paymentId
     *
     * @return bool
     */
    public function checkPayment(int $paymentId): bool
    {
        return $this->orderHelper->getPaymentObject()->getId() === $paymentId;
    }

    /**
     * @param int $confirmations
     *
     * @return bool
     */
    public function checkConfirmations(int $confirmations): bool
    {
        return $confirmations >= $this->pluginConfig['confirmations'];
    }
}
