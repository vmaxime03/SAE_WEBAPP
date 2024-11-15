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
            <input type="submit" name="triDateRecente" value="Trier par date de soirée la plus récente"></input>
            <input type="submit" name="triStyleSoiree" value="Trier par theme de la soirée(A-Z)"></input>
            <input type="submit" name="triLieu" value="Trier par Lieu(A-Z)"></input>
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
            $html .= "<a href=\"?action=AfficherSpectacle&id=" . htmlspecialchars($id) . "\">Afficher les spectacles de cette soiree</a>";
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
        if (isset($_POST['triDateRecente'])){
            $nomtri = filter_var($_POST['triDateRecente']);
            if ($nomtri = "Trier par date de soirée la plus récente") $this->triActif = NrvRepository::$TRI_DATE;
            else $this->triActif = NrvRepository::$TRI_DEFAUT;

        }else if (isset($_POST['triStyleSoiree'])) {
            $nomtri = filter_var($_POST['triStyleSoiree']);
            if ($nomtri = "Trier par style de soirée(A-Z)") $this->triActif = NrvRepository::$TRI_THEME_SOIREE;
            else $this->triActif = NrvRepository::$TRI_DEFAUT;
        }else if(isset($_POST['triStyleSoiree'])) {
            $nomtri = filter_var($_POST['triLieu']);
            if ($nomtri = "Trier par Lieu(A-Z)") $this->triActif = NrvRepository::$TRI_LIEU;
            else $this->triActif = NrvRepository::$TRI_DEFAUT;
        }else{
            $this->triActif = NrvRepository::$TRI_DEFAUT;
        }
        $html .= $this->affichage();
        return $html;
    }
}