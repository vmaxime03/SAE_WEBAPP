<?php

namespace Iutnc\Nrv\actions;

use Iutnc\Nrv\auth\AuthProvider;
use Iutnc\Nrv\exceptions\AuthException;

class ActionAccueilUser extends Action
{

    public function get(): string
    {
        $html = <<<HTML
    <form action="?action=accueilUser" method="POST">
        <nav>
            <h1>BIENVENUE SUR LA PAGE ACCUEIL USER</h1>
            <a href="?action=afficherSoirees">Afficher les soirées</a>
            <br>

    </form>
    HTML;
        $user = AuthProvider::getSignedInUser();
        if ($user->getRole($user) ==100){
            $html .= <<<HTML
                <a href="?action=accueilAdmin">vue admin</a>
                <br>
                <a href="?action=accueilStaff">vue Staff</a>
                HTML;
        }
        if ($user->getRole($user) ==5){
            $html .= <<<HTML
                <a href="?action=accueilStaff">vue Staff</a>
                HTML;
        }
        return $html;
    }

    public function post(): string
    {
        return "Hello World!";
    }



}