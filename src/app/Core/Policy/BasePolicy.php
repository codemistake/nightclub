<?php

namespace App\Core\Policy;

use App\Core\AccessControl\AccessChecker;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Class BasePolicy
 *
 * @package App\Core\Policy
 */
abstract class BasePolicy
{
    use HandlesAuthorization;
    /** @var AccessChecker */
    protected $accessChecker;

    /**
     * @param AccessChecker $accessChecker
     */
    public function __construct(AccessChecker $accessChecker)
    {
        $this->accessChecker = $accessChecker;
    }

    /**
     * @return bool|null
     */
    public function before(): ?bool
    {
        if ($this->accessChecker->isRoot()) {
            return true;
        }
        return null;
    }
}
