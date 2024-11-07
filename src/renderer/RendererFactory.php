<?php

namespace Iutnc\Nrv\renderer;

use Iutnc\Nrv\classes\Renderable;

class RendererFactory
{
    public static function getRenderer(Renderable $toRender) : Renderer {
        return match (get_class($toRender)) {
            //TODO
            default => throw new \Exception("renderer inconnu"),
        };
    }
}