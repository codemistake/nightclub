<?php

namespace App\Component\Core\Validation;

use Assert\Assert as BaseAssert;

/**
 * Class Assert
 * @package App\Component\Core\Validation
 */
class Assert extends BaseAssert
{
    /**
     * {@inheritdoc}
     */
    protected static $assertionClass = Assertion::class;
}
