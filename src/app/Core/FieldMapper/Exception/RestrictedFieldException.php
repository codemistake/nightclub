<?php

namespace App\Core\FieldMapper\Exception;

/**
 * Class RestrictedFieldException
 *
 * @package App\Core\Exception\FieldMapper
 */
class RestrictedFieldException extends \RuntimeException
{
    /** @var string */
    private $field;

    /**
     * @param string $field
     *
     * @return RestrictedFieldException
     */
    public static function withField(string $field): self
    {
        return (new static("No access to field [{$field}]"))->setField($field);
    }


    /**
     * @param string $field
     *
     * @return RestrictedFieldException
     */
    public function setField(string $field): self
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
