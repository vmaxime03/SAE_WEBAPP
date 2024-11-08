<?php

namespace Iutnc\Nrv\actions;

use Iutnc\Nrv\repository\NrvRepository;

class ActionAfficherSoirees extends Action
{
    public function get(): string
    {
        $instance = NrvRepository::getInstance();
        $html = '';
        $id = 1;
        while ($soiree = $instance->getSoireebyId($id)) {
            $html .= "<p>{$soiree->nom}</p>";
            $id++;
        }
        return $html;
    }

    public function post(): string
    {
        // TODO: Implement post() method.
    }
}