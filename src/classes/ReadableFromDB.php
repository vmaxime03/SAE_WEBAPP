<?php

namespace Iutnc\Nrv\classes;

interface ReadableFromDB
{
    /**
     * @param mixed $obj Output de la base de donne fetch avec FETCH_OBJ
     * @return User
     */
    public static function createFromDb(mixed $obj) : mixed;
}