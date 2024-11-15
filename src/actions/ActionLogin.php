<?php

namespace Iutnc\Nrv\actions;

use Iutnc\Nrv\auth\AuthProvider;
use Iutnc\Nrv\exceptions\AuthException;
use Iutnc\Nrv\classes\User;

/**
 * action login
 * voir Authprovider pour les details
 */
class ActionLogin extends Action
{
    private string $form = <<<HTML
    <form action="?action=login" method="POST">
    <link rel="stylesheet" href="../style.css">
    <div class="tout">
        <div class="login">
                    <input type="email" name="email" placeholder="email">
                    <input type="password" name="passwd" placeholder="mot de passe">
                    <input type="submit" value="Confirmer">
         </div>
     </div>
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
            return $this->form . "entrée manquante";
        }

        try {
            $user = AuthProvider::getSignedInUser();
            if ($user->email === $_POST["email"] &&
                password_verify($_POST['passwd'], $user->passwd)) {
                return "Vous êtes déjà connecté ";
            } else {
                throw new AuthException();
            }
        } catch (AuthException $e) {
            try {
                $user = AuthProvider::signin($_POST["email"], $_POST["passwd"]);
                return "Rebonjour " . $user->email;
            } catch (AuthException $e) {
                return $this->form . "erreur lors de la connexion";
            }
        }
    }
}