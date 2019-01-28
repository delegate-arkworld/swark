<?php

namespace Swark\Services;

use Shopware\Components\Model\ModelManager;
use Shopware\Models\Order\Order;
use Shopware\Models\Order\Status;
use Swark\Helper\OrderHelper;
use Swark\Helper\PluginHelper;
use Swark\Structs\Attributes;

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

            /** @var Attributes $attributes */
            $attributes = $this->orderHelper->getOrderAttributes($order->getAttribute());

            $transaction = $this->transactionService->getTransaction(
                $attributes['swarkRecipientAddress'],
                $attributes['swarkVendorField']
            );

            if ($transaction) {
                if (!$transaction->getId()) {
                    $this->updateOrderTransactionId($order->getAttribute(), $transaction->getId(), $order->getNumber());
                }

                $transactionAmount = $transaction->getAmount()/100000000;

                if (!$this->checkOrderAmount($transactionAmount, $attributes['swarkArkAmount'])) {
                    $this->loggerService->notify(
                        'Order [' . $order->getNumber() . '] received amount is too low: ' . $transactionAmount . '. Needed: ' . $attributes['swarkArkAmount']
                    );

                    /** @var Status $paymentStatus */
                    $paymentStatus = $this->models->getRepository(Status::class)->find(Status::PAYMENT_STATE_PARTIALLY_PAID);

                    $this->updateOrderPaymentStatus($order, $paymentStatus);
                    continue;
                }

                if (!$this->checkConfirmations($transaction->getConfirmations())) {
                    $this->loggerService->notify(
                        'Order [' . $order->getNumber() . '] need more confirmations. Currently: ' . $transaction->getConfirmations()
                    );
                    continue;
                }

                $this->updateOrderPaymentStatus($order, $this->orderHelper->getPaymentStatus());

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
     * @throws \Exception
     *
     * @return bool
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

            if ($order->getCurrency() !== 'ARK') {
                $amount = 0;
                // TODO: calculate with ARK amount
            } else {
                $amount = $order->getInvoiceAmount();
            }

            $attributes->setSwarkArkAmount($amount);

            $this->models->persist($attributes);
            $this->models->flush($attributes);
        } catch (\Exception $e) {
            $this->loggerService->error('Order amount could not be updated!', $e->getTrace());
            throw $e;
        }

        $this->loggerService->notify(
            'Updated amount to [' . $amount . '] for order [' . $order->getNumber() . ']'
        );
    }

    /**
     * @param \Shopware\Models\Attribute\Order $attributes
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
     * @param int|null $statusId
     * @return bool
     * @throws \Exception
     */
    public function updateOrderPaymentStatus(Order $order, Status $paymentStatus): bool
    {
        try {
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

    /**
     * @param float $transactionAmount
     * @param float $orderAmount
     *
     * @return bool
     */
    public function checkOrderAmount(float $transactionAmount, float $orderAmount): bool
    {
        return ($transactionAmount >= $orderAmount) ? true : false;
    }
}
