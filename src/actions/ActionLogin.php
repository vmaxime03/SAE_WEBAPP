<?php

namespace Iutnc\Nrv\actions;

use Iutnc\Nrv\auth\AuthProvider;
use Iutnc\Nrv\exceptions\AuthException;

class ActionLogin extends Action
{
    private string $form = <<<HTML
    <form action="?action=login" method="POST">
                <input type="email" name="email" placeholder="email">
                <input type="password" name="passwd" placeholder="mot de passe">
                <input type="submit" value="Confirmer">
    </form>
    HTML;

    public function getRoleUser(string $role): string
    {
        $html = '';
        switch ($role) {
            case "ROLE_ADMIN":
                $html = "<br><a href='?action=accueilAdmin'>Accueil</a>";
                break;
            case "ROLE_USER":
                $html = "<br><a href='?action=accueilUser'>Accueil</a>";
                break;
            case "ROLE_STAFF":
                $html = "<br><a href='?action=accueilStaff'>Accueil</a>";
                break;
            default:
                $html = "<br><a href='?action=accueil'>Accueil</a>";
                break;
        }
        return $html;
    }

    public function get(): string
    {
        return $this->form;
    }

    public function post(): string
    {
        if (!(isset($_POST['email']) && isset($_POST['passwd'])) ||
            $_POST['email'] == "" || $_POST['passwd'] == "") {
            return $this->form . "entrée manquante";
        }

        try {
            $user = AuthProvider::getSignedInUser();
            if ($user->email === $_POST["email"] &&
                password_verify($_POST['passwd'], $user->passwd)) {
                return "Vous êtes déjà connecté " . $this->getRoleUser($user->role);
            } else {
                throw new AuthException();
            }
        } catch (AuthException $e) {
            try {
                $user = AuthProvider::signin($_POST["email"], $_POST["passwd"]);
                return "Rebonjour " . $user->email . $this->getRoleUser($user->role);
            } catch (AuthException $e) {
                return $this->form . "erreur lors de la connexion";
            }
        }
    }
}