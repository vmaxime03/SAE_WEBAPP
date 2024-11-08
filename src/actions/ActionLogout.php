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

            return  <<<HTML
            <form action="?action=logout" method="POST">
                <input type="submit" value="Se deconecter">
            </form>
            HTML;

        } catch (AuthException $e) {
            return <<<HTML
                <p>No user Conected</p>
            HTML;
        }
    }

    public function post(): string
    {
        unset($_SESSION['user']);
        return <<<HTML
            <p> user disconected</p>
        HTML;
    }
}