<?php

namespace App\Core\Exception\Http;

use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;

/**
 * Class ServiceUnavailableException
 * @package App\Core\Exception\Http
 */
class ServiceUnavailableException extends ServiceUnavailableHttpException
{
    /**
     * @return ServiceUnavailableException
     */
    public static function newInstance(): self
    {
        return static('Internal server error. Please, try again later.');
    }
}
