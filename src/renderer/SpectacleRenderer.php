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
        $checked = "";
        if (isset($_SESSION["preferences"])) {
            $preferences = unserialize($_SESSION["preferences"]);
            if (in_array($this->toRender->id, $preferences)) {
                $checked = "checked";
            }
        }
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
            <input type="checkbox" class="preference" id="{$this->toRender->id}" onclick="handlePreference(this)" {$checked}>
        </div>
HTML;
        //TODO utiliser methode getHeure() pour afficher uniquement l'heure sans la date et pour idsoiree
    }
}