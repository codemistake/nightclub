<?php

namespace App\Core\Exception\Http;

/**
 * Interface ExceptionDataTraitInterface
 * @package App\Core\Exception\Http
 */
interface ExceptionDataInterface
{
    /**
     * @param array|null $data
     */
    public function setData(?array $data);

    /**
     * @return array|null
     */
    public function getData():?array;
}
