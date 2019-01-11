<?php

namespace App\Core\Exception\Http;

use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Class InternalServerErrorException
 * @package App\Core\Exception\Http
 */
class InternalServerErrorException extends HttpException
{
    public const HTTP_CODE = 500;

    /**
     * @return InternalServerErrorException
     */
    public static function newInstance(): self
    {
        return new static(self::HTTP_CODE, 'Internal server error');
    }
}
