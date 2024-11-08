<?php

namespace Iutnc\Nrv\actions;

use Iutnc\Nrv\renderer\ImageRenderer;
use Iutnc\Nrv\repository\NrvRepository;

class ActionAfficherSoirees extends Action
{
    public function get(): string
    {
        $instance = NrvRepository::getInstance();
        $html = '<div class = "soirees"><br>';
        $id = 1;
        while ($soiree = $instance->getSoireebyId($id)) {
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
            $id++;
        }
        $html .= "</div>";
        return $html;
    }

    public function post(): string
    {
        // TODO: Implement post() method.
    }
}