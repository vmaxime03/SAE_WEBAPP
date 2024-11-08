<?php

namespace Iutnc\Nrv\selectioneur;

abstract class Selectioneur
{


    public function getHTML(string $name) : string {
        $uid = uniqid();
        return <<<HTML
        <input type="hidden" name="{$name}" id="{$uid}" >
        <script>
        function select(value) {
            var field = document.getElementById("{$uid}");
            field.value = value;
        }
        </script>
        {$this->content()}
HTML;
    }
    protected function clickableDiv($value, string $innerHTML) {
        return <<<HTML
<div class="selectable" onclick="select('$value')">
$innerHTML
</div>
HTML;

    }

    protected abstract function content() : string;
}