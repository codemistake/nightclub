<?php

namespace App\Core\Http\Response;

use Symfony\Component\HttpFoundation\Response;

/**
 * Class NoContentResponse
 *
 * @package App\Core\Http\Response
 */
class NoContentResponse extends Response
{
    /**
     * @param array $headers
     *
     * @return NoContentResponse
     */
    public static function newInstance(array $headers = []): NoContentResponse
    {
        return new self(null, self::HTTP_NO_CONTENT, $headers);
    }
}
