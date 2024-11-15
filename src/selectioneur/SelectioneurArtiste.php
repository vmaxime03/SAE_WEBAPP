<?php

namespace Iutnc\Nrv\selectioneur;

use Iutnc\Nrv\renderer\RendererFactory;
use Iutnc\Nrv\repository\NrvRepository;

class SelectioneurArtiste extends Selectioneur
{

    protected function content(): string
    {
        $html = "";
        $repo = NrvRepository::getInstance();
        foreach ($repo->getAllArtiste() as $artiste) {
            $html .= $this->clickableDiv($artiste->id, RendererFactory::getRenderer($artiste)->render(), $artiste->nom);
        }
        return $html;
    }
}