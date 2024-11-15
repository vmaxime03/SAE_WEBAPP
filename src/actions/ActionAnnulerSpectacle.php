<?php

namespace Iutnc\Nrv\actions;

use Iutnc\Nrv\repository\NrvRepository;
use Iutnc\Nrv\selectioneur\SelectioneurSpectacle;

class ActionAnnulerSpectacle extends Action
{

    public function get(): string
    {
        //TODO Authz

        $html = <<<HTML
<form action="?action=annulerSpectacle" method="POST">
HTML;
        $html .= (new SelectioneurSpectacle())->getHTML('spectacleid');
        $html .= <<<HTML
<input type="submit" value="Annuler">
</form>
HTML;
        return $html;
    }

    public function post(): string
    {
        //TODO
        $spid = $this->checkPostInput('spectacleid', FILTER_SANITIZE_NUMBER_INT);

        if (!$spid) {
            return "Erreur saisie";
        }
        $repo = NrvRepository::getInstance();
        if ($repo->annulerSpectacle($spid)) {
            return "Spectacle Annulé";
        } else {
            return "Erreur annulation";
        }
    }
}