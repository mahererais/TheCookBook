<?php

namespace App\src\Security\Voter;

use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class ProfileVoter extends Voter
{
    public const ACCESS = 'PROFILE_ACCESS';

    protected function supports(string $attribute, $subject): bool
    {
        return $attribute === self::ACCESS && $subject instanceof User;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if (!$user instanceof UserInterface) {
            // L'utilisateur n'est pas connecté
            return false;
        }

        // Si l'utilisateur connecté est le même que le profil demandé
        return $user === $subject;
    }
}
