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
     * Transaction constructor.
     *
     * @param string    $id
     * @param int       $amount
     * @param string    $recipient
     * @param string    $vendorField
     * @param int       $confirmations
     * @param Timestamp $timestamp
     */
    public function __construct
    (
        string $id,
        int $amount,
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
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * @param int $amount
     */
    public function setAmount(int $amount): void
    {
        $this->amount = $amount;
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
     */
    public function setRecipient(string $recipient): void
    {
        $this->recipient = $recipient;
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
     */
    public function setVendorField(string $vendorField): void
    {
        $this->vendorField = $vendorField;
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
     */
    public function setConfirmations(int $confirmations): void
    {
        $this->confirmations = $confirmations;
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
     */
    public function setTimestamp(Timestamp $timestamp): void
    {
        $this->timestamp = $timestamp;
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
            'timestamp' => $this->getTimestamp()->getUnix()
        ];
    }
}
