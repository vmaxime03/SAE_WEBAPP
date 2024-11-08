<?php

namespace Iutnc\Nrv\actions;
use Iutnc\Nrv\repository\NrvRepository;

class ActionAfficherSpectacle extends Action {

    public function get(): string
    {
        $instance = NrvRepository::getInstance();
        $html = '';
        $id = 1;
        while ($spectacles = $instance->getSpectableByIdsoiree($id)) {
            $html .= "<p>{$spectacles->titre}</p>";
            $html .= "<p>{$spectacles->heure}</p>";
            $html .= "<p>{$spectacles->videoUrl}</p>";
            $html .= "Pour la soiree"."<p>{$spectacles->idSoiree}</p>";

            $id++;
        }
        return $html;
    }

    public function post(): string
    {
        return "Hello World!";
    }

    /**
     * public function getSpectableByIdsoiree($id_soiree) : Spectacle|false
     * {
     * $stmt = $this->pdo->prepare("SELECT * FROM spectacle WHERE id_soiree = '$id_soiree'");
     * $stmt->execute();
     * $result = $stmt->fetchAll(PDO::FETCH_OBJ);
     * if ($result && count($result) == 1) {
     * return Spectacle::createFromDb($result[0]);
     * } else {
     * return false;
     * }
     * }
     */


}