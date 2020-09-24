<?php

namespace App\Security\Voter;

use App\Entity\Post;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class PostAuthorVoter extends Voter
{
    protected function supports($attribute, $subject)
    {
        return in_array($attribute, ['POST_EDIT', 'POST_DELETE'])
            && $subject instanceof Post;
    }

    /**
     * @param Post $subject
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        if (in_array('ROLE_ADMIN', $token->getRoleNames())) {
            return true;
        }
        if (in_array('ROLE_AUTHOR', $token->getRoleNames())) {
            return $subject->getWrittenBy()->getUser() === $user;
        }

        return false;
    }
}
