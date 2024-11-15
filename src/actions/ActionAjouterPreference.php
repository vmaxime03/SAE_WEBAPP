<?php

namespace Iutnc\Nrv\actions;

use Iutnc\Nrv\repository\NrvRepository;

/**
 * action d'ajout de préference,
 * cette action est appelée uniquement par le script preference.js, pour ne pas avoir a rafraichir ou rediriger l'utilisateur qui regarde les spectacle
 * les string retournée ne sont pas utilisée
 */
class ActionAjouterPreference extends Action
{

    public function get(): string
    {
        return "err";
    }

    public function post(): string
    {
        $spectacleid = $this->checkPostInput('spectacleid', FILTER_SANITIZE_NUMBER_INT);

        if (!$spectacleid) return "erreur";

        if (isset($_SESSION["preferences"])) {
            $preferences = unserialize($_SESSION["preferences"]);
        } else {
            $preferences = array();
        }

        $repo = NrvRepository::getInstance();
        if ($repo->getSpectableById($spectacleid)) {
            $preferences[] = $spectacleid;
        }
        $_SESSION["preferences"] = serialize($preferences);
        return "succes";
    }
}