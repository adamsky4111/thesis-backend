<?php

namespace App\Service\User\Manager;

use App\Entity\User\User;
use App\Event\EventDispatcherInterface;
use App\Event\User\UserEvent;

final class DefaultVerifier implements UserVerifierInterface
{
    public function __construct(
        protected ConfirmationTokenGeneratorInterface $generator,
        protected ConfirmationTokenCheckerInterface $checker,
        protected EventDispatcherInterface $dispatcher,
    ) {}

    public function generateToken(User $user)
    {
        $this->generator->generate($user);
    }
    public function verify(User $user, $token): bool
    {
        $isValid = $this->checker->check($user, $token);
        if ($isValid) {
            $user->setIsActive(true);
            $this->dispatcher->dispatch((new UserEvent($user)), UserEvent::USER_VERIFIED);
        }

        return $isValid;
    }
}
