<?php

namespace App\Core\AccessControl;

use App\Component\User\Dto\Permission\PermissionCollectionDto;
use App\Component\User\Dto\Role\RoleIdDto;
use App\Component\User\Dto\User\UserDto;
use App\Component\User\RequestInterface\Enum\RoleIdEnumInterface;
use App\Component\User\Service\PermissionService;
use App\Core\Exception\Http\ForbiddenException;
use App\Module\User\Facade\Auth;

/**
 * Class AccessChecker
 *
 * @package App\Core\AccessControl
 */
class AccessChecker
{
    /**
     * @var PermissionCollectionDto|null
     */
    private $permissionCollection;
    /**
     * @var PermissionService
     */
    private $permissionService;

    /**
     * AccessChecker constructor.
     *
     * @param PermissionService $permissionService
     */
    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    /**
     * @param string $permissionAlias
     *
     * @return bool
     */
    public function hasPermission(string $permissionAlias): bool
    {
        if ($this->permissionCollection === null) {
            $this->permissionCollection = $this->getPermissionCollection();
        }
        return ($this->permissionCollection->getByAlias($permissionAlias) !== null);
    }

    /**
     * @return bool
     */
    public function isRoot(): bool
    {
        return ($this->getCurrentUser()->getRoleId() === RoleIdEnumInterface::ROOT);
    }

    /**
     * @return UserDto
     */
    public function getCurrentUser(): UserDto
    {
        $user = Auth::user();
        if ($user === null) {
            throw ForbiddenException::newInstance();
        }
        return $user;
    }

    /**
     * @return bool
     */
    public function isAuthorized(): bool
    {
        return Auth::user() !== null;
    }

    /**
     * @return PermissionCollectionDto
     */
    private function getPermissionCollection(): PermissionCollectionDto
    {
        if (Auth::user() === null) {
            throw ForbiddenException::newInstance();
        }

        return $this->permissionService->getCollectionByRoleId(new RoleIdDto([
            'id' => $this->getCurrentUser()->getRoleId(),
        ]));
    }
}
