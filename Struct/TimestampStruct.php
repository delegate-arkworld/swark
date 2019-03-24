<?php

namespace Swark\Struct;

/**
 * Class TimestampStruct
 */
class TimestampStruct
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
     * @return TimestampStruct
     */
    public function setEpoch(int $epoch): TimestampStruct
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
     * @return TimestampStruct
     */
    public function setUnix(int $unix): TimestampStruct
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
     * @return TimestampStruct
     */
    public function setHuman(string $human): TimestampStruct
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
