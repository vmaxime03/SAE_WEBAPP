<?php

namespace Iutnc\Nrv\classes;

use Iutnc\Nrv\exceptions\InvalidPropertyNameException;

class Artiste implements ReadableFromDB, Renderable
{
    private int $id;
    private string $nom;
    private string $info;

    public function __construct(int $id, string $nom, string $info)
    {
    }

    public static function createFromDb(mixed $obj): Artiste
    {
        return new Artiste($obj->id, $obj->nom, $obj->info);
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