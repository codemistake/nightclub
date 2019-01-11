<?php

namespace App\Component\Core\Validation;

use Assert\AssertionChain;

/**
 * Class ValidatorInterface
 * @package App\Component\Core\Validation
 */
interface ValidatorInterface
{
    /**
     * @param mixed[] $values
     *
     * @return AssertionChain
     */
    public function validateAll($values): AssertionChain;

    /**
     * @param mixed $value
     *
     * @return AssertionChain
     */
    public function validate($value): AssertionChain;

    /**
     * @return LazyAssertion
     */
    public function validateLazy(): LazyAssertion;
}
