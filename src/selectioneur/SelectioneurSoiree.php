<?php

namespace Iutnc\Nrv\selectioneur;

use Iutnc\Nrv\renderer\RendererFactory;
use Iutnc\Nrv\repository\NrvRepository;

class SelectioneurSoiree extends Selectioneur
{

    protected function content(): string
    {
        $html = "";
        $repo = NrvRepository::getInstance();
        foreach ($repo->getAllSoiree() as $soiree) {
            $html .= $this->clickableDiv($soiree->id, RendererFactory::getRenderer($soiree)->render(), $soiree->nom);
        }
        return $html;
    }
}