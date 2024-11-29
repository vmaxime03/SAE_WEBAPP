<?php

namespace Iutnc\Nrv\actions;

use Iutnc\Nrv\classes\Spectacle;
use Iutnc\Nrv\renderer\RendererFactory;
use Iutnc\Nrv\repository\NrvRepository;
use Iutnc\Nrv\selectioneur\SelectioneurSoiree;
use Iutnc\Nrv\selectioneur\SelectioneurSpectacle;


/**
 * modifie un spectacle, fonctionnement :
 * on choisit un spectacle (getFormSelect)
 * on effectue les changements (getFormSpectacle)
 * le spectacle est mis ajour
 *
 * le bon formulaire est ré-envoyer en cas d'erreur de saisie ou d'id illégaux
 */
class ActionModifierSpectacle extends Action
{
    private function getFormSpectacle(int $spectacleid = -1, int $soireeid = -1, string $titre = "", string $description = "", string $heure = "",
                             string $duree = "", string $style = "", string $videourl = "", bool $annule = false) : string
    {
        echo $heure . "   " . $duree . "<br>";
        $h = date_format(new \DateTimeImmutable($heure), "H:i");
        echo $h;
        $get = $spectacleid == -1 ?"":"&spectacleid=$spectacleid";
        $form = "";
        if ($spectacleid != -1) {
            $form .= <<<HTML
<a href="?action=ajouterArtiste$get">Ajouter artiste</a>
<a href="?action=ajouterImage$get">Ajouter Image</a>
HTML;
        }
        $checked = $annule?"checked":"";
        $form .= <<<HTML
    <form action="?action=modifierSpectacle$get" method="POST">
                <input type="text" name="titre" placeholder="titre" value="$titre"> 
                <input type="text" name="description" placeholder="description" value="$description"> 
                <input type="time" name="heure" placeholder="heure" value="$h"> 
                <input type="text" name="duree" placeholder="duree" value="$duree">
                <input type="text" name="style" placeholder="style" value="$style"> 
                <input type="text" name="videourl" placeholder="videourl" value="$videourl"> 
                <input type="checkbox" name="estannule" $checked>
                <label for="annule">annulé ?</label>
    HTML;
        if ($soireeid == -1) {
            $form .= (new SelectioneurSoiree())->getHTML("soiree");
        } else {
            $form .= "<input type='hidden' name='soiree' value=$soireeid>";
        }

        $form .= <<<HTML
        <input type="submit" value="Confirmer">
    </form>
HTML;
        return $form;
    }

    private function getFormSelect() {
    $html = <<<HTML
<form method="POST" action="?action=modifierSpectacle">
HTML;
    $html .= (new SelectioneurSpectacle())->getHTML('spectacleidamodifer');
    $html .= <<<HTML
<button type="submit">Modifier</button>
</form>
HTML;
    return $html;
}

    public function get(): string
    {
        $auth = $this->checkAuthzStaff();
        if ($auth) return $auth;

        return $this->getFormSelect();
    }

    public function post(): string
    {
        $auth = $this->checkAuthzStaff();
        if ($auth) return $auth;

        $repo = NrvRepository::getInstance();

        $spectacleidamodifier = $this->checkPostInput('spectacleidamodifer', FILTER_SANITIZE_NUMBER_INT);
        $spectacleid = $this->checkGetInput('spectacleid', FILTER_SANITIZE_NUMBER_INT);

        $spectacle = $repo->getSpectableById($spectacleidamodifier);

        if (!$spectacleidamodifier) {
            if (!$spectacleid) {
                return $this->getFormSelect() . "ERREUR";
            }
            else {
                $spectacle = $repo->getSpectableById($spectacleid);

                $ntitre = $this->checkPostInput('titre', FILTER_SANITIZE_SPECIAL_CHARS);
                $ndescription = $this->checkPostInput('description', FILTER_SANITIZE_SPECIAL_CHARS);
                $nheure = $this->checkPostInput('heure', FILTER_SANITIZE_SPECIAL_CHARS);
                $nduree = $this->checkPostInput('duree', FILTER_SANITIZE_SPECIAL_CHARS);
                $nstyle = $this->checkPostInput('style', FILTER_SANITIZE_SPECIAL_CHARS);
                $nvideo  = $this->checkPostInput('videourl', FILTER_SANITIZE_URL);
                $nidsoiree = $this->checkPostInput('soiree', FILTER_SANITIZE_NUMBER_INT);
                $nannule = isset($_POST['estannule']);

                $nheure = date('H:i:s', strtotime($nheure));

                if (!$ntitre || !$ndescription || !$nheure || !$nduree || !$nstyle || !$nvideo || !$nidsoiree) {
                    return $this->getFormSpectacle($spectacleid, $nidsoiree, $ntitre, $ndescription, $nheure, $nduree, $nstyle, $nvideo, $nannule);
                }
                $nspectacle = new Spectacle($spectacleid, $ntitre, $ndescription, $nheure, $nduree, $nstyle, $nvideo, $nidsoiree, $nannule?1:0);

                if ($repo->updateSpectacle($nspectacle)) {
                    return RendererFactory::getRenderer($nspectacle)->render();
                } else {
                    return "ERREUR INSERTION BASE";
                }
            }
        } else {
            if (!$spectacleid) {
                $spectacle = $repo->getSpectableById($spectacleidamodifier);
                return $this->getFormSpectacle($spectacleidamodifier, $spectacle->idSoiree, $spectacle->titre, $spectacle->description,
                    $spectacle->heure, $spectacle->duree, $spectacle->style, $spectacle->videoUrl, $spectacle->est_annule);
            }
            else {
                return $this->getFormSelect() . "ERREUR";
            }
        }











    }
}