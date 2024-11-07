<?php

namespace Iutnc\Nrv\renderer;

use Iutnc\Nrv\classes\Artiste;

class ArtisteRenderer implements Renderer
{
    private Artiste $toRender;

    public function __construct(Artiste $toRender)
    {
        $this->toRender = $toRender;
    }

    public function render(): string
    {
        return <<<HTML

HTML;
    }
}