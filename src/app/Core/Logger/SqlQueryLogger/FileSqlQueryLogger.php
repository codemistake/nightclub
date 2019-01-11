<?php

namespace App\Core\Logger\SqlQueryLogger;

use Illuminate\Database\Connection;
use Illuminate\Database\QueryException;
use Illuminate\Filesystem\Filesystem;

/**
 * Class FileSqlQueryLogger
 * @package App\Core\Logger\SqlQueryLogger
 */
class FileSqlQueryLogger implements SqlQueryLoggerInterface
{
    const ERROR_TIME = -1;
    const LEFT_PART_PAD_LENGTH = 12;

    /** @var Filesystem */
    private $filesystem;
    /** @var Connection[] */
    private $connectionList;
    /** @var ConnectionStat[] */
    private $connectionStatMap = [];

    /**
     * SqlQueryLogger constructor.
     * @param Filesystem $filesystem
     * @param Connection[] $connectionList
     */
    public function __construct(Filesystem $filesystem, array $connectionList)
    {
        $this->filesystem = $filesystem;
        $this->connectionList = $connectionList;

        $this->enable();
        $this->initStat();
    }

    /**
     * @param QueryException $exception
     */
    public function logException(QueryException $exception): void
    {
        /*
         * в Exception'e нету информации, на каком подключении произошла ошибка :(
         * поэтому логгируем сразу во все
         */
        foreach ($this->connectionList as $connection) {
            $connection->logQuery($exception->getSql(), $exception->getBindings(), self::ERROR_TIME);
            $connection->logQuery($exception->getMessage(), [], 0);
        }
    }

    public function flush(): void
    {
        foreach ($this->connectionList as $connection) {
            $this->doLog($connection, false);
            $connection->flushQueryLog();
        }
    }

    public function write(): void
    {
        foreach ($this->connectionList as $connection) {
            $this->doLog($connection, true);
            $connection->flushQueryLog();
        }
        // Очищаем статистику после вывода тоталов
        $this->initStat();
    }

    /**
     * @param Connection $connection
     * @param bool $printTotal
     */
    protected function doLog(Connection $connection, bool $printTotal)
    {
        $queryLog = $connection->getQueryLog();
        if (empty($queryLog)) {
            return;
        }

        $stat = $this->connectionStatMap[$connection->getName()];

        $lines = [];

        // Если это первая запись в лог по этому коннекту, добавляем таймстемп
        if ($stat->getWriteCount() === 0) {
            $lines[] = current_time()->format('d.m.Y H:i:s.u');
        }

        foreach ($queryLog as $q) {
            if ($q['time'] === self::ERROR_TIME) {
                $time = 'error';
            } else if ($q['time'] > 0) {
                $time = $this->formatQueryTime($q['time']);
                $stat->incrementQueryCount();
                $stat->addTime($q['time']);
            } else {
                $time = '';
            }

            $lines[] = $this->makeLine($time, (new SqlQueryFormatter($q['query'], $q['bindings']))->toRawSql());
        }

        // При добавлении итогов дополнительно выводим горизонтальный разделитель и пустую строку
        if ($printTotal) {
            $lines[] = $this->makeLine(str_repeat('-', self::LEFT_PART_PAD_LENGTH), str_repeat('-', 24), '-|-');
            $lines[] = $this->makeLine($this->formatTotalTime($stat->getTotalTime()), $stat->getQueryCount() . ' queries');
            $lines[] = '';
        }

        $this->writeToFile($connection->getName(), $lines);
        $stat->incrementWriteCount();
    }

    /**
     * @param $leftPart
     * @param $rightPart
     * @param string $separator
     * @return string
     */
    private function makeLine($leftPart, $rightPart, $separator = ' | '): string
    {
        return str_pad($leftPart, self::LEFT_PART_PAD_LENGTH, ' ', STR_PAD_LEFT) . $separator . $rightPart;
    }

    /**
     * @param float $queryTime
     * @return string
     */
    private function formatQueryTime(float $queryTime): string
    {
        return sprintf('%.2f', round($queryTime, 2)) . ' ms';
    }

    /**
     * @param float $totalTime
     * @return string
     */
    private function formatTotalTime(float $totalTime): string
    {
        if ($totalTime < 1000) {
            $units = 'ms';
        } else if ($totalTime < 1000 * 60) {
            $totalTime = $totalTime / 1000;
            $units = 'sec';
        } else {
            $totalTime = $totalTime / (1000 * 60);
            $units = 'min';
        }

        return round($totalTime, 2) . ' ' . $units;
    }

    /**
     * @param string $connectionName
     * @param array $lines
     */
    private function writeToFile(string $connectionName, array $lines): void
    {
        $pathParts = explode('-', current_time()->format('Y-m-d'));
        $pathParts[] = 'sql';

        $dir = logs_path() . DIRECTORY_SEPARATOR . implode(DIRECTORY_SEPARATOR, $pathParts);
        if (!$this->filesystem->exists($dir)) {
            $oldUmask = umask();
            @umask(0);
            @$this->filesystem->makeDirectory($dir, 0775, true);
            @umask($oldUmask);
        }

        $path = $dir . DIRECTORY_SEPARATOR . ($connectionName ?: 'sql') . '.log';

        if (!$this->filesystem->exists($path)) {
            $this->filesystem->put($path, '');
            @chmod($path, 0775);
        }

        $this->filesystem->append($path, implode(PHP_EOL, $lines) . PHP_EOL);
    }

    private function enable(): void
    {
        foreach ($this->connectionList as $connection) {
            $connection->enableQueryLog();
        }
    }

    private function initStat(): void
    {
        foreach ($this->connectionList as $connection) {
            $this->connectionStatMap[$connection->getName()] = new ConnectionStat();
        }
    }
}
