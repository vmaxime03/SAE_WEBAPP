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

    public function getRoleUser ($user->role) :string {
        switch ($user->role) {
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
            echo var_dump($user);
            if ($user->email === $_POST["email"] &&
                password_verify($_POST['passwd'], $user->passwd)) {
                return "Vous etes deja connecté " . getRoleUser($user->role);
            } else {
                throw new AuthException();
            }
        } catch (AuthException $e) {
            try {
                $user = AuthProvider::signin($_POST["email"], $_POST["passwd"]);
                $html = "Rebonjour " . $user->email . getRoleUser($user->role);
                }
                return $html;
            } catch (AuthException $e) {
                return $this->form . "erreur lors de la connexion";
            }
        }
    }
}