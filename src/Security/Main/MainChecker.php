<?php

namespace App\Security\Main;

use App\Entity\User\User;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAccountStatusException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class MainChecker implements UserCheckerInterface
{
    public function checkPreAuth(UserInterface $user): void
    {
        $this->checkAccess($user);
    }

    public function checkPostAuth(UserInterface $user): void
    {
        $this->checkAccess($user);
    }

    private function checkAccess(UserInterface $user): void
    {
        if (!$user instanceof User) {
            return;
        }

        if (!$user->isEnabled()) {
            throw new CustomUserMessageAccountStatusException("Votre compte n'est plus actif !");
        }
    }
}