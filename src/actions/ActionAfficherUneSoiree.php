<?php

namespace Iutnc\Nrv\actions;

use Iutnc\Nrv\renderer\ImageRenderer;
use Iutnc\Nrv\repository\NrvRepository;

/**
 * Affiche une soirée lié a un spectacle donné
 */
class ActionAfficherUneSoiree extends Action
{
    public function get(): string
    {
        $instance = NrvRepository::getInstance();
        $html = '';

        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
        if ($id === null || $id === false) {
            return '<p>Id n existe pas</p>';
        }

        $soiree = $instance->getSoireeByIdSpectacle($id);
        if (!$soiree) {
            return '<p>Pas de soiree pour ce spectacle</p>';
        }

        $html .= "<div>";
        $lieu = $instance->getLieuById($soiree->idLieu);
        $image = $instance->getImageByIdLieu($lieu->id);
        $imageRendered = new ImageRenderer($image);
        $html .= "<p>{$soiree->nom}</p>";
        $html .= "<p>{$soiree->theme}</p>";
        $html .= "<p>{$soiree->date}</p>";
        $html .= "<p>{$lieu->nom}</p>";
        $html .= "<p>{$imageRendered->render()}</p>";
        $html .= "</div>";

        return $html;
    }

    public function post(): string
    {
        return "Hello World!";
    }
}