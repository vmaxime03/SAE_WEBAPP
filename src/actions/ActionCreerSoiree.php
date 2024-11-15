<?php

namespace Iutnc\Nrv\actions;

use Iutnc\Nrv\auth\Authz;
use Iutnc\Nrv\classes\Soiree;
use Iutnc\Nrv\exceptions\AuthException;
use Iutnc\Nrv\exceptions\AuthzException;
use Iutnc\Nrv\renderer\RendererFactory;
use Iutnc\Nrv\repository\NrvRepository;
use Iutnc\Nrv\selectioneur\SelectioneurLieu;


/**
 * creer un soirée en proposant le lieu a selectionner
 */
class ActionCreerSoiree extends Action
{
    private function getForm(string $nom = "", string $theme = "", string $date = "", string $time = "", string $tarif = "") : string {
        $form = <<<HTML
    <form action="?action=creerSoiree" method="POST">
                <input type="text" name="nom" placeholder="nom" value="$nom"> 
                <input type="text" name="theme" placeholder="theme" value="$theme"> 
                <input type="date" name="date" placeholder="date" value="$date"> 
                <input type="time" name="time" placeholder="time" value="$time"> 
                <input type="number" name="tarif" step="0.01" placeholder="tarif" value="$tarif">
    HTML;
        $form .= (new SelectioneurLieu())->getHTML("lieu");
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

        return $this->getForm();
    }

    public function post(): string
    {
        $auth = $this->checkAuthzStaff();
        if ($auth) return $auth;

        $nom = $this->checkPostInput('nom', FILTER_SANITIZE_SPECIAL_CHARS);
        $theme = $this->checkPostInput('theme', FILTER_SANITIZE_SPECIAL_CHARS);
        $date = $this->checkPostInput('date', FILTER_SANITIZE_SPECIAL_CHARS);
        $time = $this->checkPostInput('time', FILTER_SANITIZE_SPECIAL_CHARS);
        $tarif = $this->checkPostInput('tarif', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $lieu = $this->checkPostInput('lieu', FILTER_SANITIZE_NUMBER_INT);

        if (!$nom || !$theme || !$date || !$time || !$tarif || !$lieu) {
            return $this->getForm($nom?:"", $theme?:"", $date?:"", $time?:"", $tarif?:"") . "ERREUR DE SAISIE";
        }

        $date = date('Y-m-d H:i:s', strtotime($date . $time));
        $tarif = floatval($tarif);
        $soiree = new Soiree(0, $nom, $theme, $date, $tarif, $lieu);
        $repo = NrvRepository::getInstance();

        try {
            $id = $repo->addSoiree($soiree);
            $soiree->id = $id;
        } catch (\Exception $e) {
            return $this->getForm($nom?:"", $theme?:"", $date?:"", $time?:"", $tarif?:"")
                                    . "ERREUR LORS DE L'ENREGISTREMENT";
        }

        $html = RendererFactory::getRenderer($soiree)->render();
        $html .= "<a href='?action=creerSpectacle&soireeid=$id'>ajouter Spectacle a cette Soiree</a>";
        return $html;

    }
}