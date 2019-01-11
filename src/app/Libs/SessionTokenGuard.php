<?php

namespace App\Libs;

use Illuminate\Auth\SessionGuard;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class SessionTokenGuard extends SessionGuard
{
    public function login(AuthenticatableContract $user, $remember = false)
    {
        parent::login($user, $remember);

        $this->session->save();
    }


}
