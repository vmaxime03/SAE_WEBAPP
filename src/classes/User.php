<?php

namespace Iutnc\Nrv\classes;

use Iutnc\Nrv\exceptions\InvalidPropertyNameException;

class User implements ReadableFromDB, Renderable
{
    public static int $ROLE_ADMIN = 5;

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

}