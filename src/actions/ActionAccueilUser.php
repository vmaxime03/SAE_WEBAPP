<?php

namespace Iutnc\Nrv\actions;

use Iutnc\Nrv\auth\AuthProvider;
use Iutnc\Nrv\exceptions\AuthException;

class ActionAccueilUser extends Action
{
    private string $form = <<<HTML
    <form action="?action=accueilUser" method="POST">
        <nav>
            <h1>BIENVENUE SUR LA PAGE ACCUEIL USER</h1>
            <a href="?action=afficherSoirees">Afficher les soirées</a>
            <br>

    </form>
    HTML;

    public function get(): string
    {
        return $this->form;
    }

    public function post(): string
    {
        return "Hello World!";
    }



}