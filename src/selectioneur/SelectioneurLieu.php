<?php

namespace Iutnc\Nrv\selectioneur;

use Iutnc\Nrv\renderer\RendererFactory;
use Iutnc\Nrv\repository\NrvRepository;

class SelectioneurLieu extends Selectioneur
{

    protected function content(): string
    {
        $html = "";
        $repo = NrvRepository::getInstance();
        foreach ($repo->getAllLieu() as $lieu) {
            $html .= $this->clickableDiv($lieu->id, RendererFactory::getRenderer($lieu)->render(), $lieu->nom);
        }
        return $html;
    }
}