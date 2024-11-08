<?php

namespace Iutnc\Nrv\dispatcher;

use Iutnc\Nrv\actions\ActionAfficherSoirees;
use Iutnc\Nrv\actions\ActionDefault;
use Iutnc\Nrv\actions\ActionLogin;
use Iutnc\Nrv\actions\ActionLogout;
use Iutnc\Nrv\actions\ActionSignup;
use Iutnc\Nrv\actions\ActionAccueil;

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
            default => new ActionDefault()
        })->execute());


    }

}