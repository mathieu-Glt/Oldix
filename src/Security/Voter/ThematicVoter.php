<?php

namespace App\Security\Voter;

use App\Entity\Thematic;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class ThematicVoter extends Voter
{
    const THEMATIC_DELETE = 'thematic-delete';
    
    protected function supports(string $attribute, $thematic): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::THEMATIC_DELETE])
            && $thematic instanceof \App\Entity\Thematic;
    }

    protected function voteOnAttribute(string $attribute, $thematic, TokenInterface $token): bool
    {
        $user = $token->getUser();
        //dd($user);
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::THEMATIC_DELETE:
                //dd($attribute);
                // logic to determine if the user can delete an thematic
                return $this->canDelete($thematic, $user);
                // return true or false
                break;
        }

        return false;
    }
    
    private function canDelete(Thematic $thematic, User $user)
    {
        return $user === $thematic->getUser();

    }

}
