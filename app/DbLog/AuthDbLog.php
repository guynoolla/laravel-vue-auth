<?php

namespace App\DbLog;

use App\Models\User;
use App\Models\AuthLog;
use Illuminate\Contracts\Validation\Validator;

class AuthDbLog {

    public static function authSuccess(User $user)
    {
        $authLog = new AuthLog();

        $authLog->create([
            'user_ip' => request()->ip(),
            'status' => 1,
        ]);
    }

    public static function authFailed($errors)
    {
        $authLog = new AuthLog();

        $authLog->create([
            'user_ip' => request()->ip(),
            'status' => 0,
            'errors' => serialize($errors),
        ]);
    }
}
