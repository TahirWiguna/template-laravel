<?php

namespace App\Helpers;

class PermissionCommon
{
    public static function check($assign)
    {
        $permission = session("slug_permit");
        if (!$permission) {
            $permission = [];
        }

        if (env("BYPASS_PERMISSION_CHECK")) {
            return true;
        } else {
            return in_array($assign, $permission);
        }
    }

    public static function all()
    {
        $permission = session("slug_permit");
        if (!$permission) {
            $permission = [];
        }

        return $permission;
    }
}
