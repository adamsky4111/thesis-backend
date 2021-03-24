<?php

namespace App\Event\User;

use App\Entity\User\User;
use Symfony\Contracts\EventDispatcher\Event;

class UserEvent extends Event
{
    public const PRE_UPDATE = 'user.updated.pre';
    public const POST_UPDATE = 'user.updated.post';
    public const PRE_DELETE = 'user.deleted.pre';
    public const POST_DELETE = 'user.deleted.post';
    public const PRE_CREATE = 'user.create.pre';
    public const POST_CREATE = 'user.create.post';
    public const REGISTERED = 'user.registered';
    public const USER_VERIFIED = 'user.verified';
    public const RESTORE_PASSWORD_TOKEN_GENERATED = 'user.token.generate.restore';
    public const USER_PASSWORD_CHANGED = 'user.password.changed';


    public function __construct(
        protected User $user
    ) {}

    public function getUser(): User
    {
        return $this->user;
    }
}
