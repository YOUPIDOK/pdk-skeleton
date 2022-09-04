<?php

namespace App\Security\Admin\Voter\User;

use App\Entity\User\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class UserAdminActionVoter extends Voter
{
    // these strings are just invented: you can use anything
    const MANAGE_ROLES = 'MANAGE_ROLES';
    const EDIT_USER = 'EDIT_USER';
    const DELETE_USER = 'DELETE_USER';

    protected function supports(string $attribute, mixed $subject): bool
    {
        if (!in_array($attribute, [self::MANAGE_ROLES, self::EDIT_USER, self::DELETE_USER])) {
            return false;
        }

        if (!$subject instanceof User) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $currentUser = $token->getUser();

        if (!$currentUser instanceof User) {
            return false;
        }

        /** @var User $user */
        $user = $subject;

        switch ($attribute){
            case self::MANAGE_ROLES:
                return $currentUser->isSuperAdmin();
            case self::DELETE_USER:
                return !$user->isSuperAdmin() || ($user->isSuperAdmin() && $currentUser->isSuperAdmin());
            case self::EDIT_USER:
                return !$user->isSuperAdmin() || ($user->isSuperAdmin() && $currentUser->isSuperAdmin());
        }

        return false;
    }
}