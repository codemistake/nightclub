<?php

namespace App\Core\Exception\External;

use App\Core\Exception\Base\RecoverableErrorException;
use Psr\Http\Message\ResponseInterface;

class ExternalResourceNotAvailableException extends RecoverableErrorException
{
    /** @var ResponseInterface */
    protected $response;

    public function hasResponse(): bool
    {
        return $this->response !== null;
    }

    /**
     * @return ResponseInterface
     */
    public function getResponse(): ResponseInterface
    {
        return $this->response;
    }

    /**
     * @param ResponseInterface $response
     */
    public function setResponse(ResponseInterface $response)
    {
        $this->response = $response;
    }
}
