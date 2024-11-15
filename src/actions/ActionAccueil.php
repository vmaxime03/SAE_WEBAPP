<?php

namespace Iutnc\Nrv\actions;

use Iutnc\Nrv\auth\AuthProvider;
use Iutnc\Nrv\exceptions\AuthException;

class ActionAccueil extends Action
{

    public function get(): string
    {
        $html = <<<HTML
    <form action="?action=accueil" method="POST">
        <nav>
            <h1>BIENVENUE SUR LA PAGE ACCUEIL</h1>
            <br>
            <a href="?action=logout"> Se deconnecter</a>
            <br>
            <a href="?action=afficherSoirees">Afficher les soirées</a>
            <br>
        </nav>
    </form>
HTML;
        $htmlStaff = <<<HTML
            <a href="?action=creerSoiree">créer Soirée</a>
            <br>
            <a href="?action=creerSoiree">créer Spectacle</a>
            <br>

HTML;

        $user = AuthProvider::getSignedInUser();
        switch($user->getRole($user)){
            case 5:
                $html .= $htmlStaff;
                break;
            case 100:
                $html .= $htmlStaff;
                $html .= <<<HTML
                <a href="?action=signup"> Enregistrer un membre du Staff</a>
HTML;
                break;
        }
        return $html;
    }

    public function post(): string
    {
        return "Hello World!";
    }
}