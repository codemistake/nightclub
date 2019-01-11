<?php

namespace App\Core\Policy;

/**
 * Class DictionaryPolicy
 * @package App\Core\Policy
 */
class DictionaryPolicy extends BasePolicy
{
    public const VIEW_PERMISSION_ALIAS = 'base@dictionary@view';
    public const CONTROL_PERMISSION_ALIAS = 'base@dictionary@control';

    /**
     * @return bool
     */
    public function list(): bool
    {
        return true;
    }

    /**
     * @return bool
     */
    public function get(): bool
    {
        return true;
    }

    /**
     * @return bool
     */
    public function create(): bool
    {
        return $this->accessChecker->hasPermission(self::CONTROL_PERMISSION_ALIAS);
    }

    /**
     * @return bool
     */
    public function update(): bool
    {
        return $this->accessChecker->hasPermission(self::CONTROL_PERMISSION_ALIAS);
    }

    /**
     * @return bool
     */
    public function delete(): bool
    {
        return $this->accessChecker->hasPermission(self::CONTROL_PERMISSION_ALIAS);
    }
}
