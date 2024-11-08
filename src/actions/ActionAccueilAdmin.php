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
        <h1>BIENVENUE SUR LA PAGE ACCUEIL ADMIN</h1>
            <a href="?action=afficherSoirees">Afficher les soirées</a>
            <br>
            <a href="?action=accueilStaff">vue staff</a>
            <br>
            <a href="?action=accueilUser">vue user</a>

    </form>
    HTML;
        } catch (AuthException $e) {
            $user = AuthProvider::getSignedInUser();
            $html = <<<HTML
                <p>Vous n'avez pas les droits pour accéder à cette page</p>
            HTML;
            return $html . $user->choixAccueilByRole($user->role);
        }
    }

    public function post(): string
    {
        return "Hello World!";
    }
}