<?php

namespace Iutnc\Nrv\actions;

use Iutnc\Nrv\repository\NrvRepository;

class ActionAfficherSoirees extends Action
{
    public function get(): string
    {
        $instance = NrvRepository::getInstance();
        $html = <<<HTML
        <p>{$instance->getSoireebyId(1)->nom}</p>
        <p>{$instance->getSoireebyId(2)->nom}</p>
        <p>{$instance->getSoireebyId(3)->nom}</p>
HTML;
        //TODO Faire une boucle pour ajouter toutes les soirées
        return $html;
    }

    public function post(): string
    {
        // TODO: Implement post() method.
    }
}