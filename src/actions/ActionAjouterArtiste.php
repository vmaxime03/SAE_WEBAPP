<?php

namespace Iutnc\Nrv\actions;

use Iutnc\Nrv\repository\NrvRepository;
use Iutnc\Nrv\selectioneur\SelectioneurArtiste;

class ActionAjouterArtiste extends Action
{


    public function get(): string
    {
        // TODO: AUTHZ

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
        // TODO AUTHZ

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