<?php

namespace Iutnc\Nrv\classes;

/**
 * indique si la classe peut lire l'output d'une requete sql
 */
interface ReadableFromDB
{
    /**
     * @param mixed $obj Output de la base de donne fetch avec FETCH_OBJ
     * @return User
     */
    public static function createFromDb(mixed $obj) : mixed;
}