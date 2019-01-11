<?php

namespace App\Core\Exception\Http;

/**
 * Trait ExceptionDataTrait
 * @package App\Core\Exception\Http
 */
trait ExceptionDataTrait
{
    /** @var null|array */
    private $data;

    /**
     * @return null|array
     */
    public function getData(): ?array
    {
        return $this->data;
    }

    /**
     * @param null|array $data
     *
     * @return ExceptionDataTrait
     */
    public function setData(?array $data): self
    {
        $this->data = $data;

        return $this;
    }
}
