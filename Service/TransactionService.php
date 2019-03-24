<?php

namespace Swark\Service;

use ArkEcosystem\Client\ConnectionManager;
use Swark\Struct\TimestampStruct;
use Swark\Struct\TransactionStruct;

/**
 * Class TransactionService
 */
class TransactionService
{
    /**
     * @var ConnectionManager
     */
    private $connectionManager;

    /**
     * @var LoggerService
     */
    private $loggerService;

    /**
     * @param ConnectionService $connectionService
     * @param LoggerService     $loggerService
     */
    public function __construct(
        ConnectionService $connectionService,
        LoggerService $loggerService
    ) {
        $this->connectionManager = $connectionService->getConnectionManager();
        $this->loggerService = $loggerService;
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

        if ($transaction) {
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

        return null;
    }

    /**
     * @param string $wallet
     * @param string $vendorField
     *
     * @return array
     */
    protected function getTransactionByVendorField(string $wallet, string $vendorField): array
    {
        try {
            $response = $this->connectionManager
                ->connection('main')->transactions()->search([
                    'recipientId' => $wallet,
                    'vendorFieldHex' => implode(unpack('H*', $vendorField)),
                ]);
        } catch (\Exception $e) {
            $this->loggerService->warning('main node api was not executable', $e->getTrace());
            try {
                $response = $this->connectionManager
                    ->connection('backup')->transactions()->search([
                        'recipientId' => $wallet,
                        'vendorFieldHex' => \implode(\unpack('H*', $vendorField)),
                    ]);
            } catch (\Exception $e) {
                $this->loggerService->error('backup node api was not executable', $e->getTrace());
            }
        }

        return $response['data'][0] ?: [];
    }
}
