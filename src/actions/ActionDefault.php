<?php

namespace Iutnc\Nrv\actions;

class ActionDefault extends Action
{

    public function get(): string
    {
        return <<<HTML
        <form action="?action=default" method="POST">
            <div>
                <a href="?action=signup">Creer un compte</a>
                <br>
                <a href="?action=login"> Se connecter</a>
                <br>
                <a href="?action=afficherSoirees">Afficher les soirées</a>
             </div>
        </form>
        HTML;
    }

    public function post(): string
    {
        return "Hello World!";
    }
}