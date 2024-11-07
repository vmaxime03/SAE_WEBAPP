<?php

namespace Iutnc\Nrv\actions;

class ActionDefault extends Action
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