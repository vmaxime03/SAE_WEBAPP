<?php

namespace Iutnc\Nrv\dispatcher;

use Iutnc\Nrv\actions\ActionAfficherLieu;
use Iutnc\Nrv\actions\ActionAfficherPreference;
use Iutnc\Nrv\actions\ActionAfficherSoirees;
use Iutnc\Nrv\actions\ActionAjouterArtiste;
use Iutnc\Nrv\actions\ActionAjouterPreference;
use Iutnc\Nrv\actions\ActionAnnulerSpectacle;
use Iutnc\Nrv\actions\ActionCreerArtiste;
use Iutnc\Nrv\actions\ActionCreerImage;
use Iutnc\Nrv\actions\ActionCreerSoiree;
use Iutnc\Nrv\actions\ActionCreerSpectacle;
use Iutnc\Nrv\actions\ActionDefault;
use Iutnc\Nrv\actions\ActionLogin;
use Iutnc\Nrv\actions\ActionLogout;
use Iutnc\Nrv\actions\ActionModifierSpectacle;
use Iutnc\Nrv\actions\ActionRetirerPreference;
use Iutnc\Nrv\actions\ActionSignup;
use Iutnc\Nrv\actions\ActionAccueil;
use Iutnc\Nrv\actions\ActionAccueilStaff;
use Iutnc\Nrv\actions\ActionAccueilAdmin;
use Iutnc\Nrv\classes\Image;
use Iutnc\Nrv\exceptions\AuthException;
use Iutnc\Nrv\actions\ActionAfficherSpectacle;
use Iutnc\Nrv\actions\ActionAfficherTousSpectacle;
use Iutnc\Nrv\actions\ActionAfficherUneSoiree;
class Dispatcher
{
    private String $action;


    public function __construct() {
        $this->action = $_GET["action"]?? "none";
    }

    private function renderPage(String $html) : void {
        echo <<<HTML
        <!DOCTYPE html>
        <html lang="fr">
            <head>
                <link rel="stylesheet" href="style.css">
                <script src="preference.js"></script>
                <title>NRV</title>
            </head>
            <body>
            <div class="lien">
                <a href="?action=accueil">Accueil</a>
            </div>    
                $html
            </body>
        </html>
        HTML;
    }

    public function run() : void {
        switch ($this->action) {
            case "ajouterPreference" :
                (new ActionAjouterPreference())->execute();
                return;
            case "retirerPreference":
                (new ActionRetirerPreference())->execute();
                return;
        }
        $this::renderPage((match ($this->action) {
            "signup" => new ActionSignup(),
            "login" => new ActionLogin(),
            "logout" => new ActionLogout(),
            "afficherSoirees" => new ActionAfficherSoirees(),
            "afficherTousSpectacle" => new ActionAfficherTousSpectacle(),

            "accueil" => new ActionAccueil(),
            "creerSoiree" => new ActionCreerSoiree(),
            "creerSpectacle" => new ActionCreerSpectacle(),
            "afficherLieu" => new ActionAfficherLieu(),


            "ajouterArtiste" => new ActionAjouterArtiste(),
            "creerArtiste" => new ActionCreerArtiste(),

            "creerImage" => new ActionCreerImage(),

            "annulerSpectacle" => new ActionAnnulerSpectacle(),

            "AfficherSpectacle" => new ActionAfficherSpectacle(),

            "afficherPreference" => new ActionAfficherPreference(),
            "afficherUneSoiree" => new ActionAfficherUneSoiree(),


            "modifierSpectacle" => new ActionModifierSpectacle(),
            default => new ActionAccueil()
        })->execute());


    }

}