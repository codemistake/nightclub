<?php

namespace App\Core\Measurement;

/**
 * Class Measurable
 * @package App\Core\Measurement
 */
trait Measurable
{
    /** @var float|null */
    protected $startTime;

    protected function beforeHandle(): void
    {
        $this->startTime = $this->startTimeMeasurement();
        $this->startMemoryMeasurement();
    }

    protected function afterHandle(): void
    {
        $this->stopMemoryMeasurement();
        if ($this->startTime !== null) {
            $this->stopTimeMeasurement($this->startTime);
        }
    }

    /**
     * @return float
     */
    private function startTimeMeasurement(): float
    {
        $start = microtime(true);

        $this->line("== (queue) execution start (" . date('d.m.Y H:i:s') . ") ==");

        return $start;
    }

    /**
     * @param float $startTime
     */
    private function stopTimeMeasurement(float $startTime): void
    {
        $time = number_format(1000 * (microtime(true) - $startTime), 3, '.', '') . ' ms';
        $this->line("== (queue) execution done (" . date('d.m.Y H:i:s') . " | {$time}) ==");
    }

    private function startMemoryMeasurement(): void
    {
        $this->line('Memory Usage (' . date('d.m.Y H:i:s') . ') (start) : ' . $this->formatMemory(memory_get_usage(true)));
    }

    private function stopMemoryMeasurement(): void
    {
        $this->line('Memory Usage (' . date('d.m.Y H:i:s') . ') (end) : ' . $this->formatMemory(memory_get_usage(true)));
        $this->line('Peak Memory Usage (' . date('d.m.Y H:i:s') . ') (end) : ' . $this->formatMemory(memory_get_peak_usage(true)));
    }

    /**
     * @param int $memory
     * @return string
     */
    private function formatMemory(int $memory): string
    {
        return number_format((float) $memory / 1024 / 1024, 2) . ' MB';
    }
}
