<?php

namespace Iutnc\Nrv\auth;

use Iutnc\Nrv\exceptions\AuthException;
use Iutnc\Nrv\repository\NrvRepository;

class Authz
{
    public static function checkRole(int $id): int {
        $user = AuthnProvider::getSignedInUser();
        $repo = DeefyRepository::getInstance();
        $userData = $repo->getRoleByEmail($user['email']);

        if ($userData['role'] === 100) {
            return; // on fait rien si il est admin car il a acces a tout
        }
        $isOwner= $repo->etreProprioPlaylist($userData['id'], $playlistId);

        if (!$isOwner) {
            throw new AuthnException("Accès refusé : vous n'êtes pas le propriétaire de cette playlist.");
        }
    }
}