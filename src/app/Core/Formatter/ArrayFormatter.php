<?php

namespace App\Core\Formatter;

/**
 * Class ArrayFormatter
 *
 * @package App\Core\Formatter
 */
class ArrayFormatter
{
    /** @var array|null */
    private $array;

    /**
     * ArrayFormatter constructor.
     *
     * @param $array
     */
    public function __construct(?array $array)
    {
        $this->array = $array;
    }

    /**
     * @return int[]
     */
    public function toIntArray(): array
    {
        return $this->array !== null ? array_map('intval', $this->array) : [];
    }

    /**
     * @return int[]
     */
    public function toBoolArray(): array
    {
        if ($this->array === null) {
            return [];
        }

        return array_map(
            function ($value): bool
            {
                $positiveValues = ['1', 1, true];
                return \in_array($value, $positiveValues, true);
            },
            $this->array
        );
    }
}
