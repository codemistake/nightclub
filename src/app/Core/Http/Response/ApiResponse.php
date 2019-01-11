<?php

namespace App\Core\Http\Response;

use App\Core\Http\Response\Vo\JsonDataVo;
use App\Core\Http\Response\Vo\JsonListDataVo;
use App\Core\Http\Response\Vo\RawDataVo;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\JsonResponse;

/**
 * Class ApiResponse
 * @package App\Core\Http\Response
 */
class ApiResponse extends JsonResponse
{
    public static function empty()
    {
        return new static();
    }

    /**
     * @param Arrayable $data
     * @param int|null $total
     * @param int|null $limit
     * @param int|null $offset
     *
     * @return ApiResponse
     */
    public static function withListData(Arrayable $data, ?int $total, ?int $limit, ?int $offset): self
    {
        return (new static())->setData(
            new JsonListDataVo(
                $data,
                $total,
                $limit,
                $offset
            )
        );
    }

    /**
     * @param Arrayable $data
     *
     * @return ApiResponse
     */
    public static function withData(Arrayable $data): self
    {
        return (new static())->setData(
            new JsonDataVo($data)
        );
    }

    /**
     * @param array $data
     *
     * @return ApiResponse
     */
    public static function withRawData(array $data): self
    {
        return (new static())->setData(
            new JsonDataVo(new RawDataVo($data))
        );
    }
}
