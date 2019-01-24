<?php

namespace Swark\Structs;

/**
 * Class Attributes
 */
class Attributes
{
    /**
     * @var int
     */
    private $transactionId;

    /**
     * @var float
     */
    private $amount;

    /**
     * @var string
     */
    private $recipient;

    /**
     * @var string
     */
    private $vendorField;

    /**
     * @param int    $transactionId
     * @param float  $amount
     * @param string $recipient
     * @param string $vendorField
     */
    public function __construct
    (
        int $transactionId,
        float $amount,
        string $recipient,
        string $vendorField
    ) {
        $this->transactionId = $transactionId;
        $this->amount = $amount;
        $this->recipient = $recipient;
        $this->vendorField = $vendorField;
    }

    /**
     * @return int
     */
    public function getTransactionId(): int
    {
        return $this->transactionId;
    }

    /**
     * @param int $transactionId
     *
     * @return Attributes
     */
    public function setTransactionId(int $transactionId): Attributes
    {
        $this->transactionId = $transactionId;

        return $this;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @param float $amount
     *
     * @return Attributes
     */
    public function setAmount(float $amount): Attributes
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @return string
     */
    public function getRecipient(): string
    {
        return $this->recipient;
    }

    /**
     * @param string $recipient
     *
     * @return Attributes
     */
    public function setRecipient(string $recipient): Attributes
    {
        $this->recipient = $recipient;

        return $this;
    }

    /**
     * @return string
     */
    public function getVendorField(): string
    {
        return $this->vendorField;
    }

    /**
     * @param string $vendorField
     *
     * @return Attributes
     */
    public function setVendorField(string $vendorField): Attributes
    {
        $this->vendorField = $vendorField;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'swarkTransactionId' => $this->getTransactionId(),
            'swarkArkAmount' => $this->getAmount(),
            'swarkRecipientAddress' => $this->getRecipient(),
            'swarkVendorField' => $this->getVendorField()
        ];
    }
}
