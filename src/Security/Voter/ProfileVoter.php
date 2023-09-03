<?php

namespace App\Security\Voter;

use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAccountStatusException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

class ProfileVoter extends Voter
{
    public const ACCESS = 'PROFILE_ACCESS';

    private $flash;

    public function __construct(FlashBagInterface $flash)
    {
        $this->flash = $flash;
    }

    protected function supports(string $attribute, $subject): bool
    {
        return $attribute === self::ACCESS && $subject instanceof User;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $authenticatedUser = $token->getUser();

        if (!$authenticatedUser  instanceof User) {
            // If the user is not logged, he cannot access
            return false;
        }

        if (!$authenticatedUser->isVerified()) {
            // the message passed to this exception is meant to be displayed to the user
            $message = "Cet email n'a pas été vérifié.";
            $this->flash->add('warning', $message);
            // ! source : https://stackoverflow.com/questions/53450298/symfony-4-flash-messages-from-repository-or-somewhere-else
            throw new CustomUserMessageAccountStatusException($message);
        }

        // He can access if the user logged is the same as the URL slug :
        return $authenticatedUser->getSlug() === $subject->getSlug();
    }
}
