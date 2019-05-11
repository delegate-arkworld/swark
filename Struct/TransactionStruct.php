<?php

namespace Swark\Struct;

/**
 * Class TransactionStruct
 */
class TransactionStruct
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var int
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
     * @var int
     */
    private $confirmations;

    /**
     * @var TimestampStruct
     */
    private $timestamp;

    /**
     * @param string          $id
     * @param float           $amount
     * @param string          $recipient
     * @param string          $vendorField
     * @param int             $confirmations
     * @param TimestampStruct $timestamp
     */
    public function __construct(
        string $id,
        float $amount,
        string $recipient,
        string $vendorField,
        int $confirmations,
        TimestampStruct $timestamp
    ) {
        $this->setId($id);
        $this->setAmount($amount);
        $this->setRecipient($recipient);
        $this->setVendorField($vendorField);
        $this->setConfirmations($confirmations);
        $this->setTimestamp($timestamp);
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     *
     * @return TransactionStruct
     */
    public function setId(string $id): TransactionStruct
    {
        $this->id = $id;

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
     * @return TransactionStruct
     */
    public function setAmount(float $amount): TransactionStruct
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
     * @return TransactionStruct
     */
    public function setRecipient(string $recipient): TransactionStruct
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
     * @return TransactionStruct
     */
    public function setVendorField(string $vendorField): TransactionStruct
    {
        $this->vendorField = $vendorField;

        return $this;
    }

    /**
     * @return int
     */
    public function getConfirmations(): int
    {
        return $this->confirmations;
    }

    /**
     * @param int $confirmations
     *
     * @return TransactionStruct
     */
    public function setConfirmations(int $confirmations): TransactionStruct
    {
        $this->confirmations = $confirmations;

        return $this;
    }

    /**
     * @return TimestampStruct
     */
    public function getTimestamp(): TimestampStruct
    {
        return $this->timestamp;
    }

    /**
     * @param TimestampStruct $timestamp
     *
     * @return TransactionStruct
     */
    public function setTimestamp(TimestampStruct $timestamp): TransactionStruct
    {
        $this->timestamp = $timestamp;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'amount' => $this->getAmount(),
            'recipient' => $this->getRecipient(),
            'vendorField' => $this->getVendorField(),
            'confirmations' => $this->getConfirmations(),
            'timestamp' => $this->getTimestamp()->getUnix(),
        ];
    }
}
