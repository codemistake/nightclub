<?php

namespace App\Core\Http\Response\Vo;

use Illuminate\Contracts\Support\Arrayable;

/**
 * Class JsonListDataVo
 */
class JsonListDataVo implements Arrayable
{
    /** @var Arrayable */
    private $dataList;
    /** @var null|int */
    private $total;
    /** @var null|int */
    private $limit;
    /** @var null|int */
    private $offset;

    /**
     * JsonListDataVo constructor.
     * @param Arrayable $dataList
     * @param int|null $total
     * @param int|null $limit
     * @param int|null $offset
     */
    public function __construct(Arrayable $dataList, ?int $total, ?int $limit, ?int $offset)
    {
        $this->dataList = $dataList;
        $this->total = $total;
        $this->limit = $limit;
        $this->offset = $offset;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'status' => 'success',
            'data' => [
                'items' => $this->dataList->toArray(),
                'total' => $this->total,
                'limit' => $this->limit,
                'offset' => $this->offset,
            ]
        ];
    }
}
