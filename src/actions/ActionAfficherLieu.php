<?php

namespace Iutnc\Nrv\actions;

use Iutnc\Nrv\renderer\RendererFactory;
use Iutnc\Nrv\repository\NrvRepository;

class ActionAfficherLieu extends Action
{

    public function get(): string
    {
        $html = "";
        $repo = NrvRepository::getInstance();
        foreach ($repo->getAllLieu() as $lieu) {
            $html .= RendererFactory::getRenderer($lieu)->render();
        }
        return $html;
    }

    public function post(): string
    {
        // TODO: Implement post() method.
    }
}