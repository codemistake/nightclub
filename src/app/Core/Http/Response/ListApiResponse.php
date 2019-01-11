<?php

namespace App\Core\Http\Response;

class ListApiResponse extends ApiResponse
{
    /**
     * @param array $items
     * @param int|null $total
     * @param int|null $limit
     * @param int|null $offset
     * @return ListApiResponse
     */
    protected function setChunkedData(array $items, ?int $total, ?int $limit, ?int $offset): ListApiResponse
    {
        $this->setData([
            'items' => $items,
            'total' => $total,
            'limit' => $limit,
            'offset' => $offset,
        ]);

        return $this;
    }
}