<?php

namespace Iutnc\Nrv\actions;

use Iutnc\Nrv\auth\AuthProvider;
use Iutnc\Nrv\exceptions\AuthException;
use Iutnc\Nrv\exceptions\CreateUserException;

/**
 * creer un utilisateur
 * avec double entrée du mot de pass
 * les admin peuvent creer des membres du staffs
 */
class ActionSignup extends Action
{
    private string $form = <<<HTML
    <form action="?action=signup" method="POST">
    <link rel="stylesheet" href="../style.css">
    <div class="tout">
        <div class="signup">
                <input type="email" name="email" placeholder="email">
                <input type="password" name="passwd" placeholder="mot de passe">
                <input type="password" name="passwd2" placeholder="confirmer mot de passe">
                <input type="submit" value="Confirmer">
                <ul>
                    <li>Le mot de passe doit contenir au moins :</li>
                    <li>10 caractères</li>
                    <li>un chiffre</li>
                    <li>un caractère spécial</li>
                    <li>une majuscule</li>
                    <li>une minuscule</li>
                </ul>
        </div>        
    </div>
    </form>
    HTML;

    public function get(): string
    {
        try {
            $user = AuthProvider::getSignedInUser();
            if ($user->getRole($user)==100) {
                return "<br>Enregistrer un nouveau membre du staff <br>" . $this->form;
            }
        } catch (AuthException $e) {
            return "<br>Enregistrer un nouveau utilisateur <br>" . $this->form;
        }
        return "<br>Enregistrer un nouveau utilisateur <br>" . $this->form;
    }

    public function post(): string
    {
        if (!(isset($_POST['email']) && isset($_POST['passwd']) && isset($_POST['passwd2'])) ||
            $_POST['email'] == "" || $_POST['passwd'] == "" || $_POST['passwd2'] == "") {
            return $this->form . "entrée manquante ";
        }

        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            return $this->form . "email invalide";
        }

        if ($_POST['passwd'] != $_POST['passwd2']) {
            return $this->form . "les deux mot de passe ne sont pas identique";
        }

        try {
            $user = AuthProvider::getSignedInUser();
            if ($user->getRole($user)==100) {
                AuthProvider::registerStaff($_POST['email'], $_POST['passwd']);
                return "success <br><a href='?action=login'>Se Connecter</a>";
            }
        } catch (AuthException $e) {
            // L'internaute n'est pas connecté, donc on enregistre un utilisateur
            try {
                AuthProvider::register($_POST['email'], $_POST['passwd']);
                return "success <br><a href='?action=login'>Se Connecter</a>";
            }
            catch (AuthException $e) {
                return $this->form . "erreur mot de passe pas valide";
            } catch (AuthException $e) {
            return $this->form . "erreur mot de passe pas valide";
            }catch (CreateUserException $e) {
                return $this->form . "Erreur lors de l'enregistrement";
            }
        }

        return $this->form . "Erreur inconnue";
    }
}