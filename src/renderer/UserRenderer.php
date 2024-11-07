<?php

namespace Iutnc\Nrv\renderer;

use Iutnc\Nrv\classes\User;

class UserRenderer implements Renderer
{
    private User $toRender;

    public function __construct(User $toRender)
    {
        $this->toRender = $toRender;
    }


    public function render(): string
    {
        return <<<HTML

HTML;
    }
}