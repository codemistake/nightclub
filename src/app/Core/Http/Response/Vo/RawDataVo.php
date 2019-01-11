<?php

namespace App\Core\Http\Response\Vo;

use Illuminate\Contracts\Support\Arrayable;

/**
 * Class RawDataVo
 * @package App\Core\Http\Response\Vo
 */
class RawDataVo implements Arrayable
{
    /** @var array */
    private $data = [];

    /**
     * RawDataVo constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->data;
    }
}
