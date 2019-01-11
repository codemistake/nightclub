<?php

namespace App\Core\Http\Response\Vo;

use Illuminate\Contracts\Support\Arrayable;

/**
 * Class JsonDataVo
 * @package App\Core\Http\Response\Vo
 */
class JsonDataVo implements Arrayable
{
    /** @var array */
    private $data;

    /**
     * JsonDataVo constructor.
     * @param Arrayable $data
     * @throws \TypeError
     */
    public function __construct(Arrayable $data)
    {
        $this->data = $data;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'status' => 'success',
            'data' => $this->data->toArray(),
        ];
    }
}
