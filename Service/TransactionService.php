<?php

namespace Swark\Service;

use Swark\Component\ArkClient\ConnectionManager;
use Exception;
use Monolog\Logger;
use Swark\Struct\TimestampStruct;
use Swark\Struct\TransactionStruct;

/**
 * Class TransactionService
 *
 * @package Swark\Service
 */
class TransactionService
{
    /**
     * @var ConnectionManager
     */
    private $connectionManager;

    /**
     * @var Logger
     */
    private $errorLogger;

    /**
     * @var Logger
     */
    private $processLogger;

    /**
     * @param ConnectionService $connectionService
     * @param Logger $errorLogger
     * @param Logger $processLogger
     */
    public function __construct(
        ConnectionService $connectionService,
        Logger $errorLogger,
        Logger $processLogger
    ) {
        $this->connectionManager = $connectionService->getConnectionManager();
        $this->errorLogger = $errorLogger;
        $this->processLogger = $processLogger;
    }

    /**
     * @param string $wallet
     * @param string $vendorField
     *
     * @return TransactionStruct
     */
    public function getTransaction(string $wallet, string $vendorField): TransactionStruct
    {
        $transaction = $this->getTransactionByVendorField($wallet, $vendorField);

        if (empty($transaction)) {
            return null;
        }

        return new TransactionStruct(
            $transaction['id'],
            $transaction['amount'],
            $transaction['recipient'],
            $transaction['vendorField'],
            $transaction['confirmations'],
            new TimestampStruct(
                $transaction['timestamp']['epoch'],
                $transaction['timestamp']['unix'],
                $transaction['timestamp']['human']
            )
        );
    }

    /**
     * @param string $wallet
     * @param string $vendorField
     *
     * @return array
     */
    private function getTransactionByVendorField(string $wallet, string $vendorField): array
    {
        $response = null;

        try {
            $response = $this->connectionManager
                ->connection('main')->transactions()->search([
                    'recipientId' => $wallet,
                    'vendorFieldHex' => implode(unpack('H*', $vendorField)),
                ]);
        } catch (Exception $e) {
            $this->errorLogger->error('main node api was not executable', $e->getTrace());
            try {
                $response = $this->connectionManager
                    ->connection('backup')->transactions()->search([
                        'recipientId' => $wallet,
                        'vendorFieldHex' => \implode(\unpack('H*', $vendorField)),
                    ]);
            } catch (Exception $e) {
                $this->errorLogger->error('backup node api was not executable', $e->getTrace());
            }
        }

        return $response['data'][0] ?: [];
    }
}
