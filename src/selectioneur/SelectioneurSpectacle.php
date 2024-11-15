<?php

namespace Iutnc\Nrv\selectioneur;

use Iutnc\Nrv\renderer\RendererFactory;
use Iutnc\Nrv\repository\NrvRepository;

class SelectioneurSpectacle extends Selectioneur
{

    protected function content(): string
    {
        $html = "";
        $repo = NrvRepository::getInstance();
        foreach ($repo->getAllSpectacle() as $spectacle) {
            $html .= $this->clickableDiv($spectacle->id, RendererFactory::getRenderer($spectacle)->render(), $spectacle->titre);
        }
        return $html;
    }
}