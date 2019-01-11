<?php

namespace App\Core\Exception\Http;

use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

/**
 * Class UnauthorizedException
 * @package App\Core\Exception\Http
 */
class UnauthorizedException extends UnauthorizedHttpException implements ExceptionDataInterface
{
    use ExceptionDataTrait;

    /**
     * @return UnauthorizedException
     */
    public static function newInstance(): self
    {
        return (new static('', 'Unauthenticated'))
            ->setData(null);
    }

    /**
     * @return UnauthorizedException
     */
    public static function withBadLoginOrPassword(): self
    {
        return (new static('', 'Bad login or password'))
            ->setData(null);
    }
}
