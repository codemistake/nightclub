<?php

namespace App\Core\Logger\ApiLogger;

class ApiLogger
{
    const DIR_TREE_TYPE_BY_DAY = 1;
    const DIR_TREE_TYPE_BY_HOUR = 2;
    const DIR_TREE_TYPE_BY_MINUTE = 3;

    private $apiName;
    private $methodName;
    private $separateFiles = false;
    private $flushRequestImmediately = true;    // в случае $separateFiles = false
    private $dirTreeType = self::DIR_TREE_TYPE_BY_DAY;

    private $logDir;
    private $logFilePrefix;
    private $requestStartTime;
    private $requestLogText;
    private $statsLogText;

    public function __construct($apiName = null, $methodName = null)
    {
        $this->apiName = $apiName;
        $this->methodName = $methodName;
    }

    public function request($url, $headers, $data)
    {
        $now = current_time();

        $this->logDir = $this->tryCreateDir($now);
        $this->logFilePrefix = ($this->apiName ? $this->sanitize($this->apiName) . '_' : '')
            . $now->format('Y_m_d_H_i_s_u')
            . '_' . str_random(8)
            . ($this->methodName ? '_' . $this->sanitize($this->methodName) : '');

        $this->requestStartTime = microtime(true);

        $logText = $now->format('d.m.Y H:i:s.u') . PHP_EOL;
        $logText .= $url . PHP_EOL;
        if (is_array($headers)) {
            foreach ($headers as $k => $v) {
                $logText .= $k . ': ' . (is_array($v) ? implode(',', $v) : $v) . PHP_EOL;
            }
        }
        $logText .= is_array($data) ? json_encode($data) : $data;

        if ($this->separateFiles) {
            $this->write('1_req', $logText);
        } else {
            if ($this->flushRequestImmediately) {
                $this->write(null, $this->prepareRequestTextForLog($logText));
            } else {
                $this->requestLogText = $logText;
            }
        }
    }

    public function stats($data)
    {
        $logText = '';

        if (is_array($data)) {
            foreach ($data as $k => $v) {
                $logText .= $k . ': ' . (is_array($v) ? implode(',', $v) : $v) . PHP_EOL;
            }
        }

        if ($this->separateFiles) {
            $this->write('2_stats', $logText);
        } else {
            if ($this->flushRequestImmediately) {
                $this->write(null, $this->prepareStatsTextForLog($logText));
            } else {
                $this->statsLogText = $logText;
            }
        }
    }

    public function response($statusCode, $headers, $data)
    {
        $this->writeResponse($statusCode, $headers, $data, true);
    }

    public function error($statusCode, $headers, $data)
    {
        $this->writeResponse($statusCode, $headers, $data, false);
    }

    protected function tryCreateDir(\DateTime $date)
    {
        switch ($this->dirTreeType) {
            default:
            case self::DIR_TREE_TYPE_BY_DAY:
                $timeFormat = '';
                break;
            case self::DIR_TREE_TYPE_BY_HOUR:
                $timeFormat = 'H';
                break;
            case self::DIR_TREE_TYPE_BY_MINUTE:
                $timeFormat = 'H-i';
                break;
        }

        $pathParts = explode('-', $date->format('Y-m-d'));
        $pathParts[] = 'api';
        if ($this->apiName) {
            $pathParts[] = $this->apiName;
        }
        if ($timeFormat) {
            $pathParts = array_merge($pathParts, explode('-', $date->format($timeFormat)));
        }

        /** @var \Illuminate\Filesystem\Filesystem $filesystem */
        $filesystem = app('files');
        $dir = logs_path() . DIRECTORY_SEPARATOR . implode(DIRECTORY_SEPARATOR, $pathParts);
        if (!$filesystem->exists($dir)) {
            $oldUmask = umask();
            @umask(0);
            @$filesystem->makeDirectory($dir, 0775, true);
            @umask($oldUmask);
        }

        return $dir;
    }

    protected function writeResponse($statusCode, $headers, $data, $success = true)
    {
        $logText = '';

        if (!$this->separateFiles) {
            if (!$this->flushRequestImmediately) {
                $logText .= $this->prepareRequestTextForLog($this->requestLogText);
                $logText .= $this->prepareStatsTextForLog($this->statsLogText);
            }
            $logText .= str_repeat('=', 15) . ' RESPONSE ' . str_repeat('=', 15) . PHP_EOL . PHP_EOL;
        }

        $logText .= current_time()->format('d.m.Y H:i:s.u') . ' | ';
        $logText .= number_format(1000 * (microtime(true) - $this->requestStartTime), 3, '.', '') . ' ms' . PHP_EOL;

        if ($statusCode) {
            $logText .= "Status: " . $statusCode . PHP_EOL;
        }

        if (is_array($headers)) {
            foreach ($headers as $k => $v) {
                $logText .= $k . ': ' . (is_array($v) ? implode(',', $v) : $v) . PHP_EOL;
            }
        }

        $logText .= is_array($data) ? json_encode($data) : $data;
        $logText .= PHP_EOL;

        if ($this->separateFiles) {
            $this->write($success ? '3_resp_ok' : '3_resp_error', $logText);
        } else {
            if ($this->flushRequestImmediately) {
                $this->write(null, $logText);
                $this->appendPostfixToLogFile($success ? 'ok' : 'error');
            } else {
                $this->write($success ? 'ok' : 'error', $logText);
            }
        }
    }

    protected function write($filePostfix, $data)
    {
        if (is_array($data)) {
            $data = json_encode($data);
        }

        /** @var \Illuminate\Filesystem\Filesystem $filesystem */
        $filesystem = app('files');
        $path = $this->logDir . DIRECTORY_SEPARATOR . $this->logFilePrefix . ($filePostfix ? '_' . $filePostfix : '') . '.log';
        if (!$filesystem->exists($path)) {
            $filesystem->put($path, '');
            $oldUmask = umask();
            @umask(0);
            @chmod($path, 0775);
            @umask($oldUmask);
        }

        $filesystem->append($path, $data);
    }

    protected function appendPostfixToLogFile($filePostfix)
    {
        /** @var \Illuminate\Filesystem\Filesystem $filesystem */
        $filesystem = app('files');
        $path = $this->logDir . DIRECTORY_SEPARATOR . $this->logFilePrefix . '.log';
        if (!$filesystem->exists($path)) {
            return;
        }

        $newPath = $this->logDir . DIRECTORY_SEPARATOR . $this->logFilePrefix . ($filePostfix ? '_' . $filePostfix : '') . '.log';

        $filesystem->move($path, $newPath);
    }

    protected function prepareRequestTextForLog($requestLog)
    {
        $logText = '';
        if (!$this->separateFiles) {
            $logText .= str_repeat('=', 15) . " REQUEST " . str_repeat('=', 16) . PHP_EOL . PHP_EOL;
        }
        $logText .= $requestLog . PHP_EOL . PHP_EOL;
        return $logText;
    }

    protected function prepareStatsTextForLog($requestLog)
    {
        $logText = '';
        if (!$this->separateFiles) {
            $logText .= str_repeat('=', 16) . " STATS " . str_repeat('=', 17) . PHP_EOL . PHP_EOL;
        }
        $logText .= $requestLog . PHP_EOL . PHP_EOL;
        return $logText;
    }

    public function setSeparateFiles(bool $separateFiles)
    {
        $this->separateFiles = $separateFiles;
    }

    public function setFlushRequestImmediately(bool $flushRequestImmediately)
    {
        $this->flushRequestImmediately = $flushRequestImmediately;
    }

    public function setDirTreeType(int $dirTreeType)
    {
        $this->dirTreeType = $dirTreeType;
    }

    private function sanitize($str)
    {
        return preg_replace('#[^a-zA-Z0-9_.]#', '_', $str);
    }
}
