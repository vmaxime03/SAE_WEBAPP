<?php

namespace Iutnc\Nrv\actions;

use Iutnc\Nrv\auth\AuthProvider;
use Iutnc\Nrv\exceptions\AuthException;
use Iutnc\Nrv\renderer\RendererFactory;

/**
 * deconnecte l'utilisateur (supprime la session)
 */
class ActionLogout extends Action
{

    public function get(): string
    {

        try {
            $user = AuthProvider::getSignedInUser();

            return  <<<HTML
            <form action="?action=logout" method="POST">
                <input type="submit" value="Se Déconnecter">
            </form>
            HTML;

        } catch (AuthException $e) {
            return <<<HTML
                <p>Pas d'utilisateur connecté </p>
            HTML;
        }
    }

    public function post(): string
    {
        session_destroy();
        return <<<HTML
            <p>Utilisateur déconnecté</p>    
        HTML;
    }
}