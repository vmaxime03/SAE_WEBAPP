<?php

namespace Iutnc\Nrv\actions;

use Iutnc\Nrv\auth\Authz;
use Iutnc\Nrv\exceptions\AuthException;
use Iutnc\Nrv\repository\NrvRepository;
use Iutnc\Nrv\selectioneur\SelectioneurArtiste;

/**
 * selectionne un artiste a ajouter a un spectacle,
 * le get renvoie le formulaire et le post ajoute l'artiste a la bd en cas de succes, sinon renvoie le formulaire
 * cette page est disponique que pour les user ayant pour role staff ou admin
 * cette page est dispnible que depuis la page d'un spectacle
 */
class ActionAjouterArtiste extends Action
{


    public function get(): string
    {
        $auth = $this->checkAuthzStaff();
        if ($auth) return $auth;

        $spectacleId = $this->checkGetInput('spectacleid', FILTER_SANITIZE_NUMBER_INT);
        if (!$spectacleId) {
            return "VOUS NE DEVRIEZ PAS ETRE LA";
        }

        $html = <<<HTML
<form action="?action=ajouterArtiste&spectacleid=$spectacleId" method="POST">
HTML;
        $html .= (new SelectioneurArtiste())->getHTML("artiste");

        $html .= <<<HTML
<button type="submit">Ajouter</button>
</form>
<a href='?action=creerArtiste&spectacleid=$spectacleId'>ajouter artiste</a>
HTML;
        return $html;


    }

    public function post(): string
    {
        $auth = $this->checkAuthzStaff();
        if ($auth) return $auth;

        $spectacleId = $this->checkGetInput('spectacleid', FILTER_SANITIZE_NUMBER_INT);
        $artiste = $this->checkPostInput('artiste', FILTER_SANITIZE_NUMBER_INT);

        if (!$spectacleId || !$artiste) {
            return "ERREUR";
        }

        $repo = NrvRepository::getInstance();

        if ($repo->linkArtisteToSpectacle($spectacleId, $artiste)) {
            return "ARTISTE AJOUTER AU SPECTACLE";
        } else {
            return "ERREUR";
        }

    }
}