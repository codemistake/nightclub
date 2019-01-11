<?php

namespace App\Core\Logger\SqlQueryLogger;

/**
 * Class ConnectionStat
 * @package App\Core\Logger\SqlQueryLogger
 */
class ConnectionStat
{
    /** @var int */
    private $queryCount = 0;
    /** @var float */
    private $totalTime = 0.0;
    /** @var int */
    private $writeCount = 0;

    public function incrementQueryCount(): void
    {
        $this->queryCount++;
    }

    /**
     * @param float $time
     */
    public function addTime(float $time): void
    {
        $this->totalTime += $time;
    }

    public function incrementWriteCount(): void
    {
        $this->writeCount++;
    }

    /**
     * @return int
     */
    public function getQueryCount(): int
    {
        return $this->queryCount;
    }

    /**
     * @return float
     */
    public function getTotalTime(): float
    {
        return $this->totalTime;
    }

    /**
     * @return int
     */
    public function getWriteCount(): int
    {
        return $this->writeCount;
    }
}
