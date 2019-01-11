<?php

namespace App\Core\FieldMapper\Exception;


/**
 * Class UnknownFieldException
 *
 * @package App\Core\Exception\FieldMapper
 */
class UnknownFieldException extends \RuntimeException
{
    /** @var string */
    private $field;

    /**
     * @param string $field
     *
     * @return UnknownFieldException
     */
    public static function withField(string $field): self
    {
        return (new static(
            "Unknown field [{$field}]"))
            ->setField($field);
    }

    /**
     * @param string $field
     * @return UnknownFieldException
     */
    public function setField(string $field): UnknownFieldException
    {
        $this->field = $field;
        return $this;
    }

    /**
     * @return string
     */
    public function getField(): string
    {
        return $this->field;
    }
}
