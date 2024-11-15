<?php

namespace Iutnc\Nrv\actions;

use Iutnc\Nrv\auth\Authz;
use Iutnc\Nrv\classes\Artiste;
use Iutnc\Nrv\exceptions\AuthException;
use Iutnc\Nrv\renderer\RendererFactory;
use Iutnc\Nrv\repository\NrvRepository;
use Iutnc\Nrv\selectioneur\SelectioneurArtiste;

class ActionCreerArtiste extends Action
{

    public function getForm(int $spectacleId = -1, string $nom = "", string $info = "") {
        $sid = $spectacleId==-1 ? "" : "&spectacleId=$spectacleId";
        return <<<HTML
<form action="?action=creerArtiste$sid" method="POST">
    <input type="text" name="nom" value="">
    <input type="text" name="info" value="">
<button type="submit">Ajouter</button>
</form>
HTML;
    }

    public function get(): string
    {
        $auth = $this->checkAuthzStaff();
        if ($auth) return $auth;


        $spectacleId = $this->checkGetInput('spectacleId', FILTER_SANITIZE_NUMBER_INT);
        return $spectacleId?$this->getForm($spectacleId):$this->getForm();



    }

    public function post(): string
    {
        $auth = $this->checkAuthzStaff();
        if ($auth) return $auth;

        $spectacleId = $this->checkGetInput('spectacleId', FILTER_SANITIZE_NUMBER_INT);
        $nom = $this->checkGetInput('nom', FILTER_SANITIZE_SPECIAL_CHARS);
        $info = $this->checkGetInput('info', FILTER_SANITIZE_SPECIAL_CHARS);

        if (!$nom || !$info) {
            return $this->getForm($spectacleId?:-1, $nom?:"", $info?:"") . "ERREUR DE SAISIE";
        }

        $repo = NrvRepository::getInstance();

        $artiste = new Artiste(-1, $nom, $info);
        $aid = $repo->addArtiste($artiste);

        $html = RendererFactory::getRenderer($artiste)->render() . "ARTISTE CREER";

        if ($spectacleId) {
            $repo->linkArtisteToSpectacle($aid, $spectacleId);
            $html .= " ET AJOUTER AU SPECTACLE";
        }

        return $html;


    }
}