<?php

namespace App\Core\Formatter;

/**
 * Class StringFormatter
 * @package App\Core\Formatter
 */
class StringFormatter
{
    /** @var string|null */
    private $string;

    /**
     * StringFormatter constructor.
     * @param null|string $string
     */
    public function __construct(?string $string)
    {
        $this->string = $string;
    }

    /**
     * @return int[]
     */
    public function toIntArray(): array
    {
        return $this->string !== null ? array_map('intval', explode(',', $this->string)) : [];
    }

    /**
     * @return null|string
     */
    public function pascalToSnakeCase(): ?string
    {
        if ($this->string === null) {
            return null;
        }

        return preg_replace('/(?<!^)[A-Z]/', '_$0', $this->string);
    }
}
