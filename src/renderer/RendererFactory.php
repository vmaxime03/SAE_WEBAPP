<?php

namespace Iutnc\Nrv\renderer;

class RendererFactory
{
    public static function getRenderer(AudioTrack|AudioList|User $toRender) : Renderer {
        return match (get_class($toRender)) {
            //TODO
            default => throw new \Exception("renderer inconnu"),
        };
    }
}