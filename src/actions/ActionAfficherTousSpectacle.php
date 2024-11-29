<?php

namespace Iutnc\Nrv\actions;

use Iutnc\Nrv\classes\Spectacle;
use Iutnc\Nrv\renderer\ImageRenderer;
use Iutnc\Nrv\renderer\SpectacleRenderer;
use Iutnc\Nrv\repository\NrvRepository;

/**
 * Affiche tous les spectacles
 */
class ActionAfficherTousSpectacle extends Action
{
    public function get(): string
    {
        $instance = NrvRepository::getInstance();
        $html = '<div class="spectacles">';

        $spectacles = $instance->getAllSpectacle();
        if (!$spectacles) {
            return '<p>pas de spectacle trouvé</p>';
        }

        foreach ($spectacles as $spectacle) {
            $renderedSpectacle = new SpectacleRenderer($spectacle);
            $html .= $renderedSpectacle->render();
            $image = $instance->getImageByIdSpectacle($spectacle->id); //TODO plusieur image
            $imageRendered = new ImageRenderer($image);
            $html .= "<p>{$imageRendered->render()}</p>";
            $html .= "<a href=\"?action=afficherUneSoiree&id=" . htmlspecialchars($spectacle->idSoiree) . "\">Afficher la soirée correspondante</a>";
            $html .= "<p>---------------------</p>";
        }

        return $html . "</div>";
    }

    public function post(): string
    {
        return "Hello World!";
    }
}