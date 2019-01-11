<?php

namespace App\Component\Core\Validation;

use Assert\LazyAssertionException;
use Assert\LazyAssertion as BaseLazyAssertion;

/**
 * Class LazyAssertion
 *
 * @package App\Component\Core\Validation
 */
class LazyAssertion extends BaseLazyAssertion
{
    /**
     * @return bool
     *
     * @throws ValidationException
     */
    public function verifyNow(): bool
    {
        try {
            parent::verifyNow();
        } catch (LazyAssertionException $exception) {
            throw new ValidationException($exception->getMessage(), 0, 0, 0);
        }

        return true;
    }
}
