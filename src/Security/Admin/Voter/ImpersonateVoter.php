<?php

namespace App\Security\Admin\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class ImpersonateVoter extends Voter
{
    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports($attribute, $subject): bool
    {
        return in_array($attribute, ['ROLE_IMPERSONATE'])
            && $subject instanceof UserInterface;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if (!$user instanceof UserInterface || !$subject instanceof UserInterface) {
            return false;
        }

        if ($user->canImpersonate()) {
            return true;
        }

        return false;
    }
}
