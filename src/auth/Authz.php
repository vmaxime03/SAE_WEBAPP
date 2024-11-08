<?php

namespace Iutnc\Nrv\auth;

use Iutnc\Nrv\exceptions\AuthException;
use Iutnc\Nrv\repository\NrvRepository;

class Authz
{
    public static function checkRole(int $role) : void
    {
        $user = AuthProvider::getSignedInUser();
        if ($user->role < $role) {
            throw new AuthException("Vous n'avez pas le role nécessaire pour acceder a cette page");
        }
    }

    public static function checkRoleAdmin() : void
    {
        self::checkRole(NrvRepository::$ROLE_ADMIN);
    }

    public static function checkRoleStaff() : void
    {
        self::checkRole(NrvRepository::$ROLE_STAFF);
    }

    public static function checkRoleUser() : void
    {
        self::checkRole(NrvRepository::$ROLE_USER);
    }
}