<?php

namespace Iutnc\Nrv\actions;

use Iutnc\Nrv\repository\NrvRepository;

class ActionAfficherSpectacle extends Action {

    public function get(): string
    {
        $instance = NrvRepository::getInstance();
        $html = '';

        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if ($id === null || $id === false) {
            return '<p>Invalid ID</p>';
        }

        $spectacles = $instance->getSpectableByIdSoiree($id);
        if (!$spectacles) {
            return '<p>No spectacles found for this soiree</p>';
        }

        foreach ($spectacles as $spectacle) {
            $html .= "<p>{$spectacle->titre}</p>";
            $html .= "<p>{$spectacle->heure}</p>";
            $html .= "<p>{$spectacle->video}</p>";
            $html .= "<p>-------------</p>";
        }

        return $html;
    }

    public function post(): string
    {
        return "Hello World!";
    }
}