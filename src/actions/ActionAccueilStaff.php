<?php

namespace Iutnc\Nrv\actions;
use Iutnc\Nrv\auth\Authz;
use Iutnc\Nrv\exceptions\AuthException;

class ActionAccueilStaff extends Action
{


    public function get(): string
    {
        try {
            Authz::checkRole(5);
            $html = <<<HTML
    <form action="?action=accueilStaff" method="POST">
        <nav>
            <a href="?action=afficherSoirees">Afficher les soirées</a>
            <br>

    </form>
    HTML;
            return $html;
        } catch (AuthException $e) {
            return <<<HTML
                <p>Vous n'avez pas les droits pour accéder à cette page</p>
                <a href="?action=accueilUser">Retour à la page d'accueil</a>
            HTML;
        }

    }

    public function post(): string
    {
        return "Hello World!";
    }

}