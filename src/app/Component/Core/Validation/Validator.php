<?php

namespace App\Component\Core\Validation;

use Assert\AssertionChain;

/**
 * Class Validator
 * @package App\Component\Core\Validation
 *
 * @see https://github.com/beberlei/assert
 */
class Validator implements ValidatorInterface
{
    /**
     * {@inheritdoc}
     *
     * @see https://github.com/beberlei/assert#list-of-assertions
     */
    public function validate($value): AssertionChain
    {
        return Assert::that($value);
    }

    /**
     * {@inheritdoc}
     *
     * @see https://github.com/beberlei/assert#list-of-assertions
     */
    public function validateAll($valueList): AssertionChain
    {
        return Assert::thatAll($valueList);
    }

    /**
     * {@inheritdoc}
     *
     * @see https://github.com/beberlei/assert#lazy-assertions
     */
    public function validateLazy(): LazyAssertion
    {
        $assertion = new LazyAssertion();
        $assertion->setAssertClass(Assert::class);

        return $assertion;
    }
}
