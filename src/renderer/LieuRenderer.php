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
        <div class = 'lieu'>
            <p>nom : {$this->toRender->nom}</p>
            <p>infos : {$this->toRender->adresse}</p>
            <p>adresse : {$this->toRender->ville}</p>
            <p>nombre de places (assises/debout): {$this->toRender->nbPlaceAssise}/{$this->toRender->nbPlaceDebout}</p>
        </div>
HTML;
    }
}