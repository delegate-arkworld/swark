<?php

namespace Swark\Components\Structs;

/**
 * Class Timestamp
 */
class Timestamp
{
    /**
     * @var int
     */
    private $epoch;

    /**
     * @var int
     */
    private $unix;

    /**
     * @var string
     */
    private $human;

    /**
     * Timestamp constructor.
     *
     * @param int    $epoch
     * @param int    $unix
     * @param string $human
     */
    public function __construct
    (
        int $epoch,
        int $unix,
        string $human
    ) {
        $this->setEpoch($epoch);
        $this->setUnix($unix);
        $this->setHuman($human);
    }

    /**
     * @return int
     */
    public function getEpoch(): int
    {
        return $this->epoch;
    }

    /**
     * @param int $epoch
     */
    public function setEpoch(int $epoch): void
    {
        $this->epoch = $epoch;
    }

    /**
     * @return int
     */
    public function getUnix(): int
    {
        return $this->unix;
    }

    /**
     * @param int $unix
     */
    public function setUnix(int $unix): void
    {
        $this->unix = $unix;
    }

    /**
     * @return stringx
     */
    public function getHuman(): string
    {
        return $this->human;
    }

    /**
     * @param string $human
     */
    public function setHuman(string $human): void
    {
        $this->human = $human;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'epoch' => $this->getEpoch(),
            'unix' => $this->getUnix(),
            'human' => $this->getHuman()
        ];
    }
}
