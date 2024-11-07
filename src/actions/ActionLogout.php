<?php

namespace Iutnc\Nrv\actions;

use Iutnc\Nrv\auth\AuthProvider;
use Iutnc\Nrv\exceptions\AuthException;
use Iutnc\Nrv\renderer\RendererFactory;

class ActionLogout extends Action
{

    public function get(): string
    {
        try {
            $user = AuthProvider::getSignedInUser();

            return RendererFactory::getRenderer($user)->render() . <<<html
<form action="?action=logout" method="POST">
    <input type="submit" value="Se deconecter">
</form>

html;
        } catch (AuthException $e) {
            return <<<html
<p>No user Conected</p>
html;
        }


    }

    public function post(): string
    {
        unset($_SESSION['user']);
        unset($_SESSION['playlist']);
        return <<<html
<p> user disconected</p>
html;

    }
}