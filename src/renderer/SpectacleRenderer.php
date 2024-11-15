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
        //TODO spectacle annulé
        return <<<HTML
        <div class = 'spectacle'>
            <p>titre : {$this->toRender->titre}</p>
            <p>description : {$this->toRender->description}</p>
            <p>heure : {$this->toRender->heure}</p>
            <p>duree : {$this->toRender->duree}</p>
            <p>style : {$this->toRender->style}</p>
            <p> : {$this->toRender->style}</p>
            <video controls width="250">
                <source src="{$this->toRender->videoUrl}" type="video/mp4" />
            </video>
        </div>
HTML;
        //TODO utiliser methode getHeure() pour afficher uniquement l'heure sans la date et pour idsoiree
    }
}