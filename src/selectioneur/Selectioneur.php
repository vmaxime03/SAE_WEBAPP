<?php

namespace Iutnc\Nrv\selectioneur;

/**
 * Classe Selectionneur,
 * permet de creer une liste de donnees seletionables pour un formulaire
 */
abstract class Selectioneur
{

    /*
     * renvoie le contenu de la partie du formulaire
     * utilise un input hidden avec pour name le valeur donnée
     * chaque option est une div clickable
     * un click fait appel a une fonction js qui modifie la valeur de l'input caché
     */
    public function getHTML(string $name) : string { //TODO
        $inputid = uniqid();
        $nameid = uniqid();
        return <<<HTML
        <t>Selectionné : <b  id="$nameid"></b></t>
        <input type="hidden" name="{$name}" id="{$inputid}" >
        <script>
        let selected;
        let input = document.getElementById("$inputid");
        let name = document.getElementById("$nameid");
        function updateSelected(node) {
            if (selected) selected.classList.replace("selected", "selectable");
            selected = node
            selected.classList.replace("selectable", "selected");
        }
        function select(id) {
            let me = document.getElementById(id);
            updateSelected(me);
            input.value = id;
            name.innerHTML = me.dataset['name'];
        }
        </script>
        <div class="select-container">
        {$this->content()}
        </div>
HTML;
    }

    /*
     * entour le innerHtml d'un div clickable
     * la veuleur est l'id de l'option
     * l'inner html est sont contenu (renderer)
     * le nom est la valeur affichable pour visualiser l'option selectionée
     *
     */
    protected function clickableDiv($value, string $innerHTML, string $name = "") {
        return <<<HTML
<div class="select-item selectable" onclick="select('$value')" id="$value" data-name="$name">
$innerHTML
</div>
HTML;

    }

    protected abstract function content() : string;
}