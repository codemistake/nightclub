<?php

namespace App\Core\Exception\Http;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class NotFoundException
 * @package App\Core\Exception\Http
 */
class NotFoundException extends NotFoundHttpException
{
    /**
     * @param int $id
     *
     * @return NotFoundHttpException
     */
    public static function withEntityNotFound(int $id): NotFoundHttpException
    {
        return new static('Entity not found: [' . $id . ']');
    }

    /**
     * @param string $guid
     *
     * @return NotFoundException
     */
    public static function withGuid(string $guid): NotFoundException
    {
        return self::newInstance('Entity not found: [' . $guid . ']');
    }

    /**
     * @param string $guid
     *
     * @return NotFoundHttpException
     */
    public static function withEntityNotFoundByGuid(string $guid): NotFoundHttpException
    {
        return new static('Entity not found: [' . $guid . ']');
    }

    /**
     * @param string|null $message
     *
     * @return NotFoundException
     */
    public static function newInstance(?string $message = ''): NotFoundException
    {
        return new static($message);
    }
}
