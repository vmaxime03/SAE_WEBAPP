<?php

namespace Iutnc\Nrv\renderer;

use Iutnc\Nrv\classes\Lieu;

class LieuRenderer implements Renderer
{
    private Lieu $toRender;

    public function __construct(Lieu $toRender)
    {
        $this->toRender = $toRender;
    }

    public function render(): string
    {
        return <<<HTML

HTML;
    }
}