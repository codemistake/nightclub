<?php

namespace App\Core\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Core\Exception\Base\SystemException;
use App\Core\Exception\Http\ForbiddenException;

/**
 * Class CheckPermission
 *
 * @package App\Core\Http\Middleware
 */
class CheckPermission
{
    /**
     * @param $policyClass
     * @param $policy
     *
     * @return mixed
     * @throws SystemException
     */
    private function checkPolicy($policyClass, $policy)
    {
        $policyObject = app($policyClass);

        if (!method_exists($policyObject, $policy)) {
            throw new SystemException('Policy not exist in own class');
        }

        $result = $policyObject->before();
        if ($result !== null) {
            return $result;
        }

        return $policyObject->$policy();
    }

    /**
     * @param Request $request
     * @param Closure $next
     * @param null $guard
     *
     * @return mixed
     * @throws SystemException
     */
    public function handle($request, Closure $next)
    {
        $policy = $request->route()->action['policy'] ?? null;
        $policyClass = $request->route()->action['policyClass'] ?? null;
        if ($policy && $policyClass && $this->checkPolicy($policyClass, $policy) === false) {
            throw ForbiddenException::newInstance();
        }

        return $next($request);
    }
}
