<?php

namespace App\Core\Exception\Http;

use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException as BaseException;

/**
 * Class UnprocessableEntityHttpException
 * @package App\Core\Exception\Http
 */
class UnprocessableEntityHttpException extends BaseException implements ExceptionDataInterface
{
    use ExceptionDataTrait;

    /**
     * @param array $errorList
     *
     * @return UnprocessableEntityHttpException
     */
    public static function withHttpValidationErrorList(array $errorList): self
    {
        return (new static('Validation failure'))
            ->setData($errorList);
    }

    /**
     * @param string $requestField
     * @return ExceptionDataTrait|UnprocessableEntityHttpException
     */
    public static function withUserLoginAlreadyUsed(string $requestField): self
    {
        return (new static('User login already used'))
            ->setData([$requestField => 'This login already used by another user']);
    }

    /**
     * @param string $entityName
     * @param int $entityId
     *
     * @return UnprocessableEntityHttpException
     */
    public static function withNotExistEntity(string $entityName, int $entityId): self
    {
        return (new static($entityName . ' with id ' . $entityId . ' not found'))->setData(null);
    }

    /**
     * @param string $requestField
     * @param string $fieldName
     *
     * @return UnprocessableEntityHttpException
     */
    public static function withUnknownField(string $requestField, string $fieldName): self
    {
        return (new static("Unknown field [{$fieldName}]"))
            ->setData([$requestField => ["Unknown field [{$fieldName}]"]]);
    }
}
