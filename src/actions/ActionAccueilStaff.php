<?php

namespace Iutnc\Nrv\actions;
use Iutnc\Nrv\auth\AuthProvider;
use Iutnc\Nrv\auth\Authz;
use Iutnc\Nrv\exceptions\AuthException;
use Iutnc\Nrv\classes\User;

class ActionAccueilStaff extends Action
{


    public function get(): string
    {
        try {
            Authz::checkRole(5);
            $html = <<<HTML
    <form action="?action=accueilStaff" method="POST">
        <nav>
         <h1>BIENVENUE SUR LA PAGE ACCUEIL STAFF</h1>
            <a href="?action=afficherSoirees">Afficher les soirées</a>
            <br>

    </form>
    HTML;
            $user = AuthProvider::getSignedInUser();
            if ($user->getRole($user) ==100){
                $html .= <<<HTML
                <a href="?action=accueilAdmin">vue admin</a>
                <br>
                <a href="?action=accueilUser">vue user</a>
                HTML;
            }
            if ($user->getRole($user) ==5){
                $html .= <<<HTML
                <a href="?action=accueilUser">vue user</a>
                HTML;
            }
            return $html;
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