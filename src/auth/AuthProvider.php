<?php

namespace Iutnc\Nrv\auth;

use Iutnc\Nrv\classes\User;
use Iutnc\Nrv\exceptions\AuthException;
use Iutnc\Nrv\exceptions\CreateUserException;
use Iutnc\Nrv\repository\NrvRepository;

class AuthProvider
{
    public static function signin(string $email, string $password) : User {
        $repo = NrvRepository::getInstance();

        $user = $repo->getUserByEmail($email);

        if (!$user) {
            throw new AuthException("user not found");
        }

        $hash = $user->passwd;

        if (password_verify($password, $hash)) {
            $_SESSION['user'] = serialize($user->id);
        }
        else {
            throw new AuthException("Auth error : invalid credentials");
        }
        return $user;
    }

    public static function getSignedInUser() : User {
        if (isset($_SESSION["user"])) {
            $user = NrvRepository::getInstance()->getUserById(unserialize($_SESSION["user"]));
            if ($user) return $user;
        }
        throw new AuthException("User not connected");

    }


    public static function register( string $email, string $pass): void {
        if(!NrvRepository::getInstance()->getUserByEmail($email)){
            $hash = password_hash($pass, PASSWORD_DEFAULT, ['cost'=>12]);
            $user = new User(0, $email, $hash, User::$ROLE_USER);
            NrvRepository::getInstance()->addUser($user);
        } else {
            throw new CreateUserException("user already exist");
        }
    }
}