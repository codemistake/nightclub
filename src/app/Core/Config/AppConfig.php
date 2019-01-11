<?php

namespace App\Core\Config;

/**
 * Class AppConfig
 * @package App\Core\Config
 */
class AppConfig
{
    /** @var string */
    private $timezone;

    /**
     * AppConfig constructor.
     * @param string $timezone
     */
    public function __construct(string $timezone)
    {
        $this->timezone = $timezone;
    }

    /**
     * @return string
     */
    public function getTimezone(): string
    {
        return $this->timezone;
    }
}
