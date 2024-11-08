<?php

namespace Iutnc\Nrv\actions;

use Iutnc\Nrv\auth\AuthProvider;
use Iutnc\Nrv\exceptions\AuthException;

class ActionAccueil extends Action
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
        if (!(isset($_POST['email']) && isset($_POST['passwd'])) ||
            $_POST['email'] == "" || $_POST['passwd'] == "") {
            return $this->form . "entrée manquante";
        }

        try {
            $user = AuthProvider::getSignedInUser();
            echo var_dump($user);
            if ($user->email === $_POST["email"] &&
                password_verify($_POST['passwd'], $user->passwd)) {
                return "Vous etes deja connecté <br><a href=''>Accueil</a>";
            } else {
                throw new AuthException();
            }
        } catch (AuthException $e) {
            try {
                $user = AuthProvider::signin($_POST["email"], $_POST["passwd"]);
                unset($_SESSION['playlist']);
                return "Rebonjour " . $user->email . "<br><a href=''>Accueil</a>";
            } catch (AuthException $e) {
                return $this->form . "erreur lors de la connexion";
            }
        }
    }
}