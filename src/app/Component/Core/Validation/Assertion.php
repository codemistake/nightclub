<?php

namespace App\Component\Core\Validation;

use Assert\Assertion as BaseAssertion;

/**
 * Class Assertion
 * @package App\Component\Core\Validation
 */
class Assertion extends BaseAssertion
{
    /**
     * {@inheritdoc}
     */
    protected static $exceptionClass = ValidationException::class;
}
