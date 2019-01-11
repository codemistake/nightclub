<?php

namespace App\Core\Formatter;

/**
 * Class DateTimeFormatter
 *
 * @package App\Core\Formatter
 */
class DateTimeFormatter
{
    /**
     * @var \Carbon\Carbon|null
     */
    private $date;

    /**
     * DateFormatter constructor.
     *
     * @param string|\DateTime|null $date
     */
    public function __construct($date)
    {
        $this->date = $date ? \Carbon\Carbon::parse($date) : null;
    }

    /**
     * @return string|null
     */
    public function toIso(): ?string
    {
        return $this->date ? $this->date->toIso8601String() : null;
    }

    /**
     * @return null|string
     */
    public function toDate(): ?string
    {
        return $this->date ? $this->date->toDateString() : null;
    }

    /**
     * @return string|null
     */
    public function toDateTime(): ?string
    {
        return $this->date ? $this->date->toDateTimeString() : null;
    }
}
