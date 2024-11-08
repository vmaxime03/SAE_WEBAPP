<?php

namespace Iutnc\Nrv\classes;

use Iutnc\Nrv\exceptions\InvalidPropertyNameException;

class Lieu implements ReadableFromDB, Renderable
{
    private int $id;
    private string $nom;
    private string $adresse;
    private string $ville;
    private int $nbPlaceAssise;
    private int $nbPlaceDebout;


    public function __construct(int $id, string $nom, string $addresse, string $ville, int $nbPlaceAssise, int $nbPlaceDebout)
    {
        $this->id = $id;
        $this->nom = $nom;
        $this->adresse = $addresse;
        $this->ville = $ville;
        $this->nbPlaceAssise = $nbPlaceAssise;
        $this->nbPlaceDebout = $nbPlaceDebout;
            }

    public static function createFromDb(mixed $obj): Lieu
    {
        return new Lieu($obj->id, $obj->nom, $obj->adresse, $obj->ville, $obj->nbPLaceAssise, $obj->nbPlaceDebout);
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