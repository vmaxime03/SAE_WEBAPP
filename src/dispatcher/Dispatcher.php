<?php

namespace Iutnc\Nrv\dispatcher;

use Iutnc\Nrv\actions\ActionAfficherSoirees;
use Iutnc\Nrv\actions\ActionDefault;
use Iutnc\Nrv\actions\ActionLogin;
use Iutnc\Nrv\actions\ActionLogout;
use Iutnc\Nrv\actions\ActionSignup;

class Dispatcher
{
    private String $action;

    public function __construct() {
        $this->action = $_GET["action"]?? "none";
    }

    private function renderPage(String $html) : void {
        echo <<<END
<!DOCTYPE html>
<html lang="fr">
    <head>
        <link rel="stylesheet" href="style.css">
        <title>NRV</title>
    </head> 
    <body>
        <div>
        <a href="?action=signup">Creer un compte</a> <br> <a href="?action=login"> Se connecter</a> <br> <a href="?action=logout"> Se deconnecter</a> <br>
        <a href="?action=afficherSoirees">Afficher les soirées</a>
        </div>
       $html
    </body>
</html>
END;
    }

    public function run() : void {

        $this::renderPage((match ($this->action) {
            "signup" => new ActionSignup(),
            "login" => new ActionLogin(),
            "logout" => new ActionLogout(),
            "afficherSoirees" => new ActionAfficherSoirees(),
            default => new ActionDefault()
        })->execute());


    }

}