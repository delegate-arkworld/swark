<?php

namespace Swark\Structs;

/**
 * Class Transaction
 */
class Transaction
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
     * @var Timestamp
     */
    private $timestamp;

    /**
     * @param string    $id
     * @param int       $amount
     * @param string    $recipient
     * @param string    $vendorField
     * @param int       $confirmations
     * @param Timestamp $timestamp
     */
    public function __construct(
        string $id,
        float $amount,
        string $recipient,
        string $vendorField,
        int $confirmations,
        Timestamp $timestamp
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
     * @return Transaction
     */
    public function setId(string $id): Transaction
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
     * @return Transaction
     */
    public function setAmount(float $amount): Transaction
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
     * @return Transaction
     */
    public function setRecipient(string $recipient): Transaction
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
     * @return Transaction
     */
    public function setVendorField(string $vendorField): Transaction
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
     * @return Transaction
     */
    public function setConfirmations(int $confirmations): Transaction
    {
        $this->confirmations = $confirmations;

        return $this;
    }

    /**
     * @return Timestamp
     */
    public function getTimestamp(): Timestamp
    {
        return $this->timestamp;
    }

    /**
     * @param Timestamp $timestamp
     *
     * @return Transaction
     */
    public function setTimestamp(Timestamp $timestamp): Transaction
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
