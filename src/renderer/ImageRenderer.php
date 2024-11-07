<?php

namespace Iutnc\Nrv\renderer;

use Iutnc\Nrv\classes\Image;

class ImageRenderer implements Renderer
{
    private Image $toRender;

    public function __construct(Image $toRender)
    {
        $this->toRender = $toRender;
    }

    public function render(): string
    {
        $img = base64_encode($this->toRender->data);
        return <<<HTML
     <img src="data:{$this->toRender->filetype};base64,{$img}"/>
HTML;

    }
}