<?php

namespace Iutnc\Nrv\actions;

use Iutnc\Nrv\auth\AuthProvider;
use Iutnc\Nrv\exceptions\CreateUserException;

class ActionSignup extends Action
{
    private string $form = <<<HTML
<form action="?action=signup" method="POST">
            <input type="email" name="email" placeholder="email">
            <input type="password" name="passwd" placeholder="mot de passe">
            <input type="submit" value="Confirmer">
</form>
HTML;

    public function get(): string
    {
        return $this->form;

    }

    public function post(): string
    {
        if (!(isset($_POST['email']) && isset($_POST['passwd'])) ||
            $_POST['email'] == "" || $_POST['passwd'] == "") {
            return $this->form . "entrée manquante ";
        }

        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            return $this->form . "email invalide";
        }

        try {
            AuthProvider::register($_POST['email'], $_POST['passwd']);
            return "success <br><a href='?action=login'>Se Connecter</a>";
        } catch (CreateUserException $e) {
            return $this->form . "Erreur lors de l'enregistrement";
        }

    }
}