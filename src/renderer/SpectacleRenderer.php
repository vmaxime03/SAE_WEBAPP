<?php

namespace Iutnc\Nrv\renderer;

use Iutnc\Nrv\classes\Spectacle;

class SpectacleRenderer implements Renderer
{
    private Spectacle $toRender;

    public function __construct(Spectacle $toRender)
    {
        $this->toRender = $toRender;
    }

    public function render(): string
    {
        return <<<HTML

HTML;
    }
}