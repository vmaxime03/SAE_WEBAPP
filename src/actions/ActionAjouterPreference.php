<?php

namespace Iutnc\Nrv\actions;

use Iutnc\Nrv\repository\NrvRepository;

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