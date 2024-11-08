<?php

namespace Iutnc\Nrv\actions;

use Iutnc\Nrv\auth\AuthProvider;
use Iutnc\Nrv\auth\Authz;
use Iutnc\Nrv\exceptions\AuthException;

class ActionAccueilAdmin extends Action
{

    public function get(): string
    {
        try {
            Authz::checkRole(100);
            return <<<HTML
    <form action="?action=accueilStaff" method="POST">
        <nav>
            <a href="?action=afficherSoirees">Afficher les soirées</a>
            <br>
            <a href="?action=accueilStaff">vue staff</a>
            <br>
            <a href="?action=accueilUser">vue user</a>

    </form>
    HTML;
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