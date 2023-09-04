<?php

namespace App\Security\Voter;

use App\Entity\Recipe;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class RecipeVoter extends Voter
{
    public const RECIPE_MODIF = 'RECIPE_MODIF';
    public const ADD_RECIPE = 'ADD_RECIPE';

    protected function supports(string $attribute, $subject): bool
    {
        return in_array($attribute, [self::RECIPE_MODIF, self::ADD_RECIPE]) && $subject instanceof Recipe;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // the user must be logged in; if not, deny access
        if (!$user instanceof UserInterface) {
            return false;
        }

        // the subject of the authorization is about the RECIPE :
        /** @var Recipe $recipe */
        $recipe = $subject;

        if ($attribute === self::RECIPE_MODIF) {
            // check if the user of the recipe is the user trying to modify or delete the recipe
            return $recipe->getUser() === $user;
        }

        if ($attribute === self::ADD_RECIPE) {
            // allow adding a recipe only if the user is logged in
            return true;
        }

        return false;
    }
}
