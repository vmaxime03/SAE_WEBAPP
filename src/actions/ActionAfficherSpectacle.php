<?php

namespace Iutnc\Nrv\actions;

use Iutnc\Nrv\classes\Spectacle;
use Iutnc\Nrv\renderer\SpectacleRenderer;
use Iutnc\Nrv\repository\NrvRepository;

class ActionAfficherSpectacle extends Action {

    public function get(): string
    {
        $instance = NrvRepository::getInstance();
        $html = '';

        $id = $this->checkGetInput('id', FILTER_SANITIZE_NUMBER_INT);
        if ($id === null || $id === false) {
            return '<p>Invalid ID</p>';
        }

        $spectacles = $instance->getSpectableByIdSoiree($id);
        if (!$spectacles) {
            return '<p>No spectacles found for this soiree</p>';
        }

        foreach ($spectacles as $spectacle) {
            $test = new Spectacle($spectacle->id, $spectacle->titre, $spectacle->description, $spectacle->heure, $spectacle->duree, $spectacle->libelleStyle, $spectacle->video, $spectacle->id_soiree);
            $renderedTest = new SpectacleRenderer($test);
            $html .= $renderedTest->render();
            $html .= "<p>-------------</p>";
        }

        return $html;
    }

    public function post(): string
    {
        return "Hello World!";
    }
}