<?php

namespace Iutnc\Nrv\classes;

use Iutnc\Nrv\exceptions\InvalidPropertyNameException;

class Spectacle implements ReadableFromDB
{
    private int $id;
    private string $titre;
    private string $description;
    private string $heure;
    private int $duree;
    private string $style;
    private string $videoUrl;
    private int $idSoiree;

    public function __construct(int $id, string $titre, string $description, string $heure, int $duree, string $style, string $videoUrl, int $idSoiree)
    {
        $this->id = $id;
        $this->titre = $titre;
        $this->description = $description;
        $this->heure = $heure;
        $this->duree = $duree;
        $this->style = $style;
        $this->videoUrl = $videoUrl;
        $this->idSoiree = $idSoiree;
    }

    public static function createFromDb(mixed $obj): Spectacle
    {
        return new Spectacle($obj->id, $obj->titre, $obj->description, $obj->heure,$obj->duree,$obj->libelleStyle,$obj->videoUrl, $obj->id_soiree);
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