<?php

namespace App\Service\User\Manager;

use App\Entity\User\User;
use App\Event\EventDispatcherInterface;
use App\Event\User\UserEvent;
use App\Repository\User\UserRepositoryInterface;

final class DefaultVerifier implements UserVerifierInterface
{
    public function __construct(
        protected ConfirmationTokenGeneratorInterface $generator,
        protected ConfirmationTokenCheckerInterface $checker,
        protected EventDispatcherInterface $dispatcher,
        protected UserRepositoryInterface $users,
    ) {}

    public function generateToken(User $user)
    {
        $this->generator->generate($user);
    }
    public function verify(User $user, $token): bool
    {
        if ($user->getIsActive()) {
            return false;
        }

        $isValid = $this->checker->check($user, $token);
        if ($isValid) {
            $user->setIsActive(true);
            $user->setConfirmationToken(null);
            $this->users->save($user);
            $this->dispatcher->dispatch((new UserEvent($user)), UserEvent::USER_VERIFIED);
        }

        return $isValid;
    }
}
