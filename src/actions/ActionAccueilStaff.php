<?php

namespace Iutnc\Nrv\actions;

class ActionAccueilStaff extends Action
{
    private string $form = <<<HTML
    <form action="?action=accueil" method="POST">
        <nav>
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