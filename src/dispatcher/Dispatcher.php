<?php

namespace Iutnc\Nrv\dispatcher;

use Iutnc\Nrv\actions\DefaultAction;

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
       $html
    </body>
</html>
END;
    }

    public function run() : void {

        $this::renderPage((match ($this->action) {
            default => new DefaultAction()
        })->execute());


    }

}