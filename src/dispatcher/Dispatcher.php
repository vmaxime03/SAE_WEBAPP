<?php

namespace Iutnc\Nrv\dispatcher;

use Iutnc\Nrv\actions\ActionAfficherLieu;
use Iutnc\Nrv\actions\ActionAfficherSoirees;
use Iutnc\Nrv\actions\ActionCreerSoiree;
use Iutnc\Nrv\actions\ActionCreerSpectacle;
use Iutnc\Nrv\actions\ActionDefault;
use Iutnc\Nrv\actions\ActionLogin;
use Iutnc\Nrv\actions\ActionLogout;
use Iutnc\Nrv\actions\ActionSignup;
use Iutnc\Nrv\actions\ActionAccueil;
use Iutnc\Nrv\actions\ActionAccueilStaff;
use Iutnc\Nrv\actions\ActionAccueilAdmin;
use Iutnc\Nrv\exceptions\AuthException;
use Iutnc\Nrv\actions\ActionAfficherSpectacle;

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
                <title>NRV</title>
            </head>
            <body>
                <a href="?action=logout"> Se deconnecter</a>
                <a href="?action=creerSoiree"> Creer Soiree</a>
                <a href="?action=creerSpectacle"> Creer Spectacle</a>
                $html
            </body>
        </html>
        HTML;
    }

    public function run() : void {

        $this::renderPage((match ($this->action) {
            "signup" => new ActionSignup(),
            "login" => new ActionLogin(),
            "logout" => new ActionLogout(),
            "afficherSoirees" => new ActionAfficherSoirees(),

            "accueil" => new ActionAccueil(),
            "creerSoiree" => new ActionCreerSoiree(),
            "creerSpectacle" => new ActionCreerSpectacle(),
            "afficherLieu" => new ActionAfficherLieu(),

<<<<<<< HEAD
            "accueilUser" => new ActionAccueilUser(),
            "accueilAdmin" => new ActionAccueilAdmin(),
            "accueilStaff" => new ActionAccueilStaff(),
            "AfficherSpectacle" => new ActionAfficherSpectacle(),
=======
>>>>>>> 2a89d3e350f3ff3405dbbde9993e3201c604b60e
            default => new ActionDefault()
        })->execute());


    }

}