<?php

namespace App\Core\Http\Response\Vo;

use Illuminate\Contracts\Support\Arrayable;
use App\Core\Exception\Http\ExceptionDataInterface;
use App\Core\Exception\Http\ExceptionDataTrait;

/**
 * Class JsonErrorDataVo
 * @package App\Core\Http\Response\Vo
 */
class JsonErrorDataVo implements Arrayable
{
    /**
     * @var \Throwable|ExceptionDataTrait
     */
    private $exception;
    /**
     * @var bool
     */
    private $returnStackTrace;

    /**
     * JsonDataVo constructor.
     * @param \Throwable $exception
     * @param bool $returnStackTrace
     */
    public function __construct(\Throwable $exception, bool $returnStackTrace = false)
    {
        $this->exception = $exception;
        $this->returnStackTrace = $returnStackTrace;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $data = null;
        if ($this->exception instanceof ExceptionDataInterface) {
            $data = $this->exception->getData();
        }

        $data = [
            'status' => 'error',
            'data' => $data,
            'error_message' => $this->exception->getMessage(),
        ];

        if ($this->returnStackTrace) {
            $data['error_trace'] = $this->exception->getTrace();
        }

        return $data;
    }
}
