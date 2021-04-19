<?php

namespace App\Service\User\Manager;

use App\Entity\User\User;
use App\Event\EventDispatcherInterface;
use App\Event\User\UserEvent;
use App\Repository\User\UserRepositoryInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

final class DefaultRestorePassword implements RestorePasswordInterface
{
    public function __construct(
        protected ConfirmationTokenCheckerInterface $checker,
        protected ConfirmationTokenGeneratorInterface $generator,
        protected UserPasswordEncoderInterface $encoder,
        protected UserRepositoryInterface $users,
        protected EventDispatcherInterface $dispatcher,
    ) {}

    public function generateToken(User $user): bool
    {
        $this->generator->generate($user);
        $this->users->save($user);

        $this->dispatcher->dispatch((new UserEvent($user)), UserEvent::RESTORE_PASSWORD_TOKEN_GENERATED);

        return true;
    }
    public function restorePassword(User $user, string $newPassword, $token): bool
    {
        $isValid = $this->checker->check($user, $token);

        if ($isValid) {
            $user->setConfirmationToken(null);
            $this->users->upgradePassword($user, $this->encoder->encodePassword($user, $newPassword));
            $this->dispatcher->dispatch((new UserEvent($user)), UserEvent::USER_PASSWORD_CHANGED);
        }

        return $isValid;
    }
}
