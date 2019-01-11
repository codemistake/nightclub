<?php

namespace App\Core\Http\Response;

use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

/**
 * Class FileResponse
 *
 * @package App\Core\Http\Response
 */
class FileResponse extends Response
{
    /**
     * @param string $content
     * @param string $contentDisposition
     * @param string $mimeType
     *
     * @return Response
     */
    public static function withContentDisposition(
        string $content,
        string $contentDisposition,
        string $mimeType
    ): Response
    {
        $headers = [
            'Content-Type' => $mimeType,
            'Content-Transfer-Encoding' => 'Binary',
            'Content-disposition' => $contentDisposition,
        ];

        $response = new parent();
        $response->headers = new ResponseHeaderBag($headers);
        $response->setContent($content);
        return $response;
    }
}
