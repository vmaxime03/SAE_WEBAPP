<?php

namespace Iutnc\Nrv\selectioneur;

abstract class Selectioneur
{


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

    protected function clickableDiv($value, string $innerHTML, string $name = "") {
        return <<<HTML
<div class="select-item selectable" onclick="select('$value')" id="$value" data-name="$name">
$innerHTML
</div>
HTML;

    }

    protected abstract function content() : string;
}