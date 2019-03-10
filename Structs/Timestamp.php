<?php

namespace Swark\Structs;

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
     * @param int    $epoch
     * @param int    $unix
     * @param string $human
     */
    public function __construct(
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
     *
     * @return Timestamp
     */
    public function setEpoch(int $epoch): Timestamp
    {
        $this->epoch = $epoch;

        return $this;
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
     *
     * @return Timestamp
     */
    public function setUnix(int $unix): Timestamp
    {
        $this->unix = $unix;

        return $this;
    }

    /**
     * @return string
     */
    public function getHuman(): string
    {
        return $this->human;
    }

    /**
     * @param string $human
     *
     * @return Timestamp
     */
    public function setHuman(string $human): Timestamp
    {
        $this->human = $human;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'epoch' => $this->getEpoch(),
            'unix' => $this->getUnix(),
            'human' => $this->getHuman(),
        ];
    }
}
