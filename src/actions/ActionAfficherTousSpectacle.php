<?php

namespace Iutnc\Nrv\actions;

use Iutnc\Nrv\classes\Spectacle;
use Iutnc\Nrv\renderer\SpectacleRenderer;
use Iutnc\Nrv\repository\NrvRepository;

class ActionAfficherTousSpectacle extends Action
{
    public function get(): string
    {
        $instance = NrvRepository::getInstance();
        $html = '';

        $spectacles = $instance->getAllSpectacle();
        if (!$spectacles) {
            return '<p>pas de spectacle trouvé</p>';
        }

        foreach ($spectacles as $spectacle) {
            $html .= "<p>{$spectacle->titre}</p>";
            $html .= "<p>{$spectacle->heure}</p>";
            $html .= "<p>---------------------</p>";
        }

        return $html;
    }

    public function post(): string
    {
        return "Hello World!";
    }
}