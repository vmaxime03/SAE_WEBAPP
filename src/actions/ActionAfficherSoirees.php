<?php

namespace Iutnc\Nrv\actions;

use Iutnc\Nrv\renderer\ImageRenderer;
use Iutnc\Nrv\repository\NrvRepository;

class ActionAfficherSoirees extends Action
{
    private int $triActif = 0;
    private function getForm(): string
    {
        return <<<HTML
        <form action="?action=afficherSoirees" method="POST">
        <nav>
            <input type="submit" name="triDateLoin" value="Trier par date de soirée la plus loin"></input>
            <br>
            <input type="submit" name="triStyleSoiree" value="Trier par style de soirée(A-Z)"></input>
            <br>
        </form>
HTML;
    }

    public function affichage() : string{
        $tri = $this->triActif;
        $instance = NrvRepository::getInstance();
        $html = '<div class = "soirees"><br>';
        $id = 1;
        while (isset($instance->getAllSoiree($tri)[$id-1])) {
            $soiree = $instance->getAllSoiree($tri)[$id-1];
            $html .= "<div>";
            $lieu = $instance->getLieuById($soiree->idLieu);
            $image = $instance->getImageByIdLieu($lieu->id);
            $imageRendered = new ImageRenderer($image);
            $html .= "<p>{$soiree->nom}</p>";
            $html .= "<p>{$soiree->theme}</p>";
            $html .= "<p>{$soiree->date}</p>";
            $html .= "<p>{$lieu->nom}</p>";
            $html .= "<p>{$imageRendered->render()}</p>";
            $html .= "</div>";
            $id++;
        }
        $html .= "</div>";
        return $html;
    }

    public function get(): string
    {
        return $this->getForm() . $this->affichage();
    }

    public function post(): string
    {

        $html = $this->getForm();
        $nomtri = filter_var($_POST['triDateLoin']);
        if (isset($_POST['triDateLoin']) && $nomtri === "Trier par date de soirée la plus loin") {
            $this->triActif = NrvRepository::$TRI_DATE;
        } else if (isset($_POST['triStyleSoiree']) && $nomtri === "Trier par style de soirée(A-Z)") {
            $this->triActif = NrvRepository::$TRI_THEME_SOIREE;
        } else {
            $this->triActif = NrvRepository::$TRI_DEFAUT;
        }

        $html .= $this->affichage();
        return $html;
    }
}