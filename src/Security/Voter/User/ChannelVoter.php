<?php
namespace App\Security\Voter\User;

use App\Entity\Stream\Channel;
use App\Entity\User\User;
use App\Enum\AccountRoleEnum;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class ChannelVoter extends Voter
{
    const CREATE = 'create';
    const UPDATE = 'update';
    const VIEW = 'view';
    const DELETE = 'delete';


    protected function supports($attribute, $subject): bool
    {
        if (!in_array($attribute, [self::CREATE, self::UPDATE, self::VIEW])) {
            return false;
        }

        if (!$subject instanceof Channel) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            return false;
        }

        /** @var Channel $channel */
        $channel = $subject;

        switch ($attribute) {
            case self::CREATE:
                return $this->canCreate($user);
            case self::UPDATE:
                return $this->canUpdate($channel, $user);
            case self::VIEW:
                return $this->canSee($channel, $user);
            case self::DELETE:
                return $this->canDelete($channel, $user);
        }

        throw new \LogicException('This code should not be reached!');
    }

    protected function canCreate(User $user): bool
    {
        return (in_array(AccountRoleEnum::STREAM_ACCOUNT, $user->getAccount()->getRoles()));
    }

    protected function canUpdate(Channel $channel, User $user): bool
    {
        return ($channel->getAccount() === $user->getAccount());
    }

    protected function canSee(Channel $channel, User $user): bool
    {
        return true;
    }

    protected function canDelete(Channel $channel, User $user): bool
    {
        return ($channel->getAccount()->getId() === $user->getAccount()->getId());
    }
}