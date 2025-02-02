<?php

namespace Iutnc\Nrv\actions;

use Iutnc\Nrv\auth\AuthProvider;
use Iutnc\Nrv\exceptions\AuthException;

class ActionAccueil extends Action
{
    public function get(): string
    {

        $htmlUser = <<<HTML
        <form action="?action=accueil" method="POST">
            <link rel="stylesheet" href="../style.css">
            <nav class="lien">
                <h1>BIENVENUE SUR LA PAGE ACCUEIL</h1>
                <br>    
                <div class="connection">
HTML;

        try {
            $user = AuthProvider::getSignedInUser();
            $htmlUser .= <<<HTML
                    <a href="?action=logout"> Se déconnecter</a>
HTML;
        } catch (AuthException $e) {
            $htmlUser .= <<<HTML
                    <a href="?action=signup">Créer un compte</a>
                    <br>
                    <a href="?action=login"> Se connecter</a>
HTML;
        }

        $htmlUser .= <<<HTML
                </div>
                <div class="fonctionnalite">
                    <a href="?action=afficherSoirees">Afficher les soirées</a>
                    <br>
                    <a href="?action=afficherTousSpectacle">Afficher tous les spectacles</a>
                    <br>
                    <a href="?action=afficherPreference"> Afficher liste de préférences</a>
                </div>
            </nav>
        </form>
HTML;

        $htmlStaff = <<<HTML
        <nav class="lien">
            <div class="fonctionnalite">
                <a href="?action=creerSoiree">Créer Soirée</a>
                <br>
                <a href="?action=creerSpectacle">Créer Spectacle</a>
                <br>
                <a href="?action=annulerSpectacle">Annuler un spectacle</a>
                <br>
                <a href="?action=modifierSpectacle">Modifier un spectacle</a>
            </div>
        </nav>
HTML;

        try {
            $user = AuthProvider::getSignedInUser();
            switch ($user->getRole($user)) {
                case 5:
                    $html = $htmlUser;
                    $html .= $htmlStaff;
                    break;
                case 100:
                    $html = $htmlUser;
                    $html .= $htmlStaff;
                    $html .= <<<HTML
                    <nav class="lien">
                        <div class="fonctionnalite">
                            <a href="?action=signup"> Enregistrer un membre du Staff</a>
                        </div>
                    </nav>
HTML;
                    break;
                default:
                    $html = $htmlUser;
                    break;
            }
        } catch (AuthException $e) {
            $html= $htmlUser;

        }

        return $html;
    }

    public function post(): string
    {
        return "Hello World!";
    }
}