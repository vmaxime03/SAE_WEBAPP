<?php

namespace Iutnc\Nrv\classes;

use Iutnc\Nrv\exceptions\InvalidPropertyNameException;

class Spectacle implements ReadableFromDB, Renderable
{
    private int $id;
    private string $titre;
    private string $description;
    private string $heure;
    private string $duree;
    private string $style;
    private string $videoUrl;
    private int $idSoiree;
    private int $est_annule;

    public function __construct(int $id, string $titre, string $description, string $heure, string $duree, string $style, string $videoUrl, int $idSoiree, int $est_annule = 0)
    {
        $this->id = $id;
        $this->titre = $titre;
        $this->description = $description;
        $this->heure = $heure;
        $this->duree = $duree;
        $this->style = $style;
        $this->videoUrl = $videoUrl;
        $this->idSoiree = $idSoiree;
        $this->est_annule = $est_annule;
    }

    public static function createFromDb(mixed $obj): Spectacle
    {
        return new Spectacle($obj->id, $obj->titre, $obj->description, $obj->heure,$obj->duree,$obj->libelleStyle,$obj->video, $obj->id_soiree, $obj->est_annule);
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