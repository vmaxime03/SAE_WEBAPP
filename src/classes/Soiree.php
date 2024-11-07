<?php

namespace Iutnc\Nrv\classes;

use Iutnc\Nrv\exceptions\InvalidPropertyNameException;

class Soiree implements ReadableFromDB
{
    private int $id;
    private string $nom;
    private string $theme;
    private string $date;
    private double $tarif;
    private int $idieu;

    public function __construct(int $id, string $nom, string $theme, string $date, int $tarif, int $idieu)
    {
        $this->id = $id;
        $this->nom = $nom;
        $this->theme = $theme;
        $this->date = $date;
        $this->tarif = $tarif;
        $this->idieu = $idieu;
    }

    public static function createFromDb(mixed $obj) : Soiree
    {
        return new Soiree($obj->id, $obj->nom, $obj->theme, $obj->date, $obj->tarif, $obj->id_ieu);
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