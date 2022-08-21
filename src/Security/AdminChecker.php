<?php

namespace App\Security;

use App\Entity\User\User;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAccountStatusException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class AdminChecker implements UserCheckerInterface
{
    public function checkPreAuth(UserInterface $user): void
    {
        if (!$user instanceof User) {
            return;
        }

        if (!$user->isAdmin() && !$user->isSuperAdmin()) {
            throw new CustomUserMessageAccountStatusException("Vous n'êtes pas administrateur !");
        }
    }

    public function checkPostAuth(UserInterface $user): void
    {
        if (!$user instanceof User) {
            return;
        }

        if (!$user->isAdmin() && !$user->isSuperAdmin()) {
            throw new CustomUserMessageAccountStatusException("Vous n'êtes pas administrateur !");
        }
    }
}