<?php

namespace Iutnc\Nrv\actions;

class DefaultAction extends Action
{

    public function get(): string
    {
        return "Hello World!";
    }

    public function post(): string
    {
        return "Hello World!";
    }
}