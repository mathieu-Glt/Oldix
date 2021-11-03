<?php

namespace App\Security\Voter;

use App\Entity\User;
use App\Entity\Language;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class LanguageVoter extends Voter
{
    const LANGUAGE_DELETE = "language_delete";
    const LANGUAGE_EDIT = "language_edit";

    protected function supports(string $attribute, $subject): bool
    {
        return in_array($attribute, [self::LANGUAGE_DELETE,self::LANGUAGE_EDIT])
            && $subject instanceof \App\Entity\Language;
    }

    protected function voteOnAttribute(string $attribute, $language, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::LANGUAGE_DELETE:

                return $this->canDelete($language, $user);
                break;
            case self::LANGUAGE_EDIT:

                return $this->canDelete($language, $user);
                break;
        }

        return false;
    }
    private function canDelete(Language $language, User $user){
        return $user === $language->getOwner();
    }
}
