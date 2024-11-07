<?php

namespace Iutnc\Nrv\renderer;

use Iutnc\Nrv\classes\Soiree;
use Iutnc\Nrv\classes\User;

class SoireeRenderer implements Renderer
{
    private Soiree $toRender;

    public function __construct(Soiree $toRender)
    {
        $this->toRender = $toRender;
    }

    public function render(): string
    {
        return <<<HTML

HTML;
    }
}