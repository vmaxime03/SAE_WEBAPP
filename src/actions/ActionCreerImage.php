<?php

namespace Iutnc\Nrv\actions;

use Iutnc\Nrv\auth\Authz;
use Iutnc\Nrv\classes\Image;
use Iutnc\Nrv\exceptions\AuthException;
use Iutnc\Nrv\renderer\RendererFactory;
use Iutnc\Nrv\repository\NrvRepository;

/**
 * creer un image
 * si la page est apprlée avec un spectacleid dans l'url, l'image creer est ajouter au spectacle
 */
class ActionCreerImage extends Action
{

    private function getForm(int $spectacleid = null) {
        if (!is_null($spectacleid)) {
            $spec = "&spectacleid=$spectacleid";
        } else {
            $spec = "";
        }
        return <<<HTML
<form action="?action=creerImage$spec" enctype="multipart/form-data" method="POST">
    <textarea name="description" placeholder="description">
    </textarea>
    <label>Audio :</label>
    <input type="file" name="image" placeholder="null">
    <br>
    <input type="submit" value="Ajouter Image">
</form>
HTML;
    }

    public function get(): string
    {
        $auth = $this->checkAuthzStaff();
        if ($auth) return $auth;

        $sid = $this->checkGetInput('spectacleid', FILTER_SANITIZE_NUMBER_INT);
        if (!$sid) {
            return "erreur";
        }else {
            return $this->getForm($sid);
        }
    }

    public function post(): string
    {
        $auth = $this->checkAuthzStaff();
        if ($auth) return $auth;

        $spid = $this->checkGetInput('spectacleid', FILTER_SANITIZE_NUMBER_INT);
        $description = $this->checkPostInput('description', FILTER_SANITIZE_SPECIAL_CHARS);

        if (!$spid || !$description) {
            return "erreur saisie";
        }

        if ($_FILES['image']['error'] !== UPLOAD_ERR_OK || explode('/', $_FILES['image']['type'])[0] !== "image") {
            return $this->getForm() . "erreur fichier";
        }

        $imgdata = base64_encode(file_get_contents($_FILES['image']['tmp_name']));

        $img = new Image(-1, $_FILES['image']['type'], $description, $imgdata);

        $repo = NrvRepository::getInstance();
        $imgid = $repo->addImage($img);


        $repo->linkImageToSpectacle($imgid, $spid);


        return RendererFactory::getRenderer($img)->render();


    }
}