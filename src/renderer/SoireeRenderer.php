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
        <div class = 'soiree'>
            <p>nom : {$this->toRender->nom}</p>
            <p>theme : {$this->toRender->theme}</p>
            <p>date : {$this->toRender->date}</p>
            <p>tarif : {$this->toRender->tarif}</p>
        </div>
HTML;
        //TODO utiliser methodes getHeure(), getLieu() pour ajouter l'heure et le lieu
    }
}