<?php

namespace Iutnc\Nrv\renderer;

use Iutnc\Nrv\classes\Artiste;
use Iutnc\Nrv\classes\Image;
use Iutnc\Nrv\classes\Lieu;
use Iutnc\Nrv\classes\Renderable;
use Iutnc\Nrv\classes\Soiree;
use Iutnc\Nrv\classes\Spectacle;
use Iutnc\Nrv\classes\User;

class RendererFactory
{
    public static function getRenderer(Renderable $toRender) : Renderer {
        return match (get_class($toRender)) {
            Artiste::class => new ArtisteRenderer($toRender),
            Lieu::class => new LieuRenderer($toRender),
            Soiree::class => new SoireeRenderer($toRender),
            Spectacle::class => new SpectacleRenderer($toRender),
            User::class  => new UserRenderer($toRender),
            Image::class => new ImageRenderer($toRender),
            default => throw new \Exception("renderer inconnu"),
        };
    }
}