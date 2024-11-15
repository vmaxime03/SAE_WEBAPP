<?php

namespace Iutnc\Nrv\actions;

use Iutnc\Nrv\renderer\RendererFactory;
use Iutnc\Nrv\repository\NrvRepository;

class ActionAfficherPreference extends Action
{
    public function get(): string
    {
        $html = "<div class='soirees'>";
        if (isset($_SESSION["preferences"])) {
            $preference = unserialize($_SESSION["preferences"]);

            if (count($preference) > 0) {
                $repo = NrvRepository::getInstance();
                $html .= "<div>";
                foreach ($preference as $key => $value) {
                    $preference[$key] = htmlspecialchars($value);
                    $spectacle = $repo->getSpectableById($value);
                    if ($spectacle) {
                        $html .= RendererFactory::getRenderer($spectacle)->render();
                    }
                }
                return $html . "</div>";
            }
        }
        return "Liste vide";

    }

    public function post(): string
    {
        return "err";
    }
}