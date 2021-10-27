<?php

namespace App\Security\Voter;

use App\Entity\Category;
use App\Entity\Thematic;
use App\Entity\User;
use ContainerFkwI9oL\getUserRepositoryService;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class CategoryVoter extends Voter
{
    const CATEGORY_DELETE = "category_delete";
    protected function supports(string $attribute, $category): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::CATEGORY_DELETE])
            && $category instanceof \App\Entity\Category;
    }

    protected function voteOnAttribute(string $attribute, $category, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::CATEGORY_DELETE:
                return $this->canDelete($category, $user);
                break;
        }

        return false;
    }
    private function canDelete(Category $category, User $user){
        return $user === $category->getOwner();
    }

}
