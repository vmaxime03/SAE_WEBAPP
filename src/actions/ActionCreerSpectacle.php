<?php

namespace Iutnc\Nrv\actions;

use Iutnc\Nrv\auth\AuthProvider;
use Iutnc\Nrv\auth\Authz;
use Iutnc\Nrv\classes\Spectacle;
use Iutnc\Nrv\exceptions\AuthException;
use Iutnc\Nrv\exceptions\AuthzException;
use Iutnc\Nrv\renderer\RendererFactory;
use Iutnc\Nrv\repository\NrvRepository;
use Iutnc\Nrv\selectioneur\SelectioneurLieu;
use Iutnc\Nrv\selectioneur\SelectioneurSoiree;

/**
 * creer un spectacle en choisissant la soirrée du spectacle
 */
class ActionCreerSpectacle extends Action
{
    private function getForm(int $soireeid = -1, string $titre = "", string $description = "", string $heure = "",
                             string $duree = "", string $style = "", string $videourl = "") : string
    {
        $form = <<<HTML
    <form action="?action=creerSpectacle" method="POST">
                <input type="text" name="titre" placeholder="titre" value="$titre"> 
                <input type="text" name="description" placeholder="description" value="$description"> 
                <input type="time" name="heure" placeholder="heure" value="$heure"> 
                <input type="text" name="duree" placeholder="duree" value="$duree">
                <input type="text" name="style" placeholder="style" value="$style"> 
                <input type="text" name="videourl" placeholder="videourl" value="$videourl"> 
    HTML;
        if ($soireeid == -1) {
            $form .= (new SelectioneurSoiree())->getHTML("soiree");
        } else {
            $form .= "<input type='hidden' name='soiree' value=$soireeid>";
        }

        $form .= <<<HTML
        <input type="submit" value="Confirmer">
    </form>
HTML;
    return $form;
    }

    public function get(): string
    {
        $auth = $this->checkAuthzStaff();
        if ($auth) return $auth;



        if (isset($_GET["soireeid"])&& $_GET["soireeid"] == filter_var($_GET["soireeid"], FILTER_VALIDATE_INT)) {
            return $this->getForm($_GET['soireeid']);
        } else {
            return $this->getForm();
        }
    }

    public function post(): string
    {
        $auth = $this->checkAuthzStaff();
        if ($auth) return $auth;

        $titre = $this->checkPostInput('titre', FILTER_SANITIZE_SPECIAL_CHARS);
        $description = $this->checkPostInput('description', FILTER_SANITIZE_SPECIAL_CHARS);
        $heure = $this->checkPostInput('heure', FILTER_SANITIZE_SPECIAL_CHARS);
        $duree = $this->checkPostInput('duree', FILTER_SANITIZE_SPECIAL_CHARS);
        $style = $this->checkPostInput('style', FILTER_SANITIZE_SPECIAL_CHARS);
        $video  = $this->checkPostInput('videourl', FILTER_SANITIZE_URL);
        $idsoiree = $this->checkPostInput('soiree', FILTER_SANITIZE_NUMBER_INT);

        if (!$titre || !$description || !$heure || !$duree || !$style || !$video || !$idsoiree) {
            return $this->getForm($idsoiree?:-1, $titre?:"", $description?:"", $heure?:"",
                $duree?:"", $style?:"", $video?:"") . "ERREUR DE SAISIE";
        }

        $heure = date('H:i:s', strtotime($heure));
        $spectacle = new Spectacle(-1, $titre, $description, $heure, $duree, $style, $video, $idsoiree);
        $repo = NrvRepository::getInstance();

        try {
            $id = $repo->addSpectacle($spectacle);
            $spectacle->id = $id;
        } catch (\Exception $e) {
            return $this->getForm($idsoiree?:-1, $titre?:"", $description?:"", $heure?:"",
                $duree?:"", $style?:"", $video?:"") . "ERREUR D'ENREGISTREMENT";
        }

        $html = RendererFactory::getRenderer($spectacle)->render();
        $html .= "<a href='?action=creerImage&spectacleid=$id'>ajouter image</a><br>";
        $html .= "<a href='?action=ajouterArtiste&spectacleid=$id'>ajouter artiste</a>";
        return $html;
    }
}