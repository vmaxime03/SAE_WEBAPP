<?php

namespace Iutnc\Nrv\classes;

use Iutnc\Nrv\exceptions\InvalidPropertyNameException;

class User implements ReadableFromDB, Renderable
{
    public static int $ROLE_ADMIN = 100;
    public static int $ROLE_USER = 1;
    public static int $ROLE_STAFF = 5;

    private int $id;
    private string $email;
    private string $passwd;
    private int $role;

    public function __construct(int $id, string $email, string $passwd, int $role)
    {
        $this->id = $id;
        $this->email = $email;
        $this->passwd = $passwd;
        $this->role = $role;
    }

    public static function createFromDb(mixed $obj) : User
    {
        return new User($obj->id, $obj->email, $obj->passwd, $obj->role);
    }

    public function __get(string $name)
    {
        if (property_exists($this, $name)) {
            return $this->$name;
        } else {
            throw new InvalidPropertyNameException($name);
        }
    }

    public function __set(string $name, $value): void
    {
        if (property_exists($this, $name)) {
            $this->$name = $value;
        } else {
            throw new InvalidPropertyNameException($name);
        }
    }

    public function getRoleUser(int $role): string
    {
        $html = '';
        switch ($role) {
            case 100:
                $html = "<br><a href='?action=accueilAdmin'>Accueil</a>";
                break;
            case 5:
                $html = "<br><a href='?action=accueilStaff'>Accueil</a>";
                break;
            default:
                $html = "<br><a href='?action=accueilUser'>Accueil</a>";
                break;
        }
        return $html;
    }

}