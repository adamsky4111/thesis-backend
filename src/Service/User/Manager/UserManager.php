<?php

namespace App\Service\User\Manager;

use App\Entity\User\User;
use App\Event\EventDispatcherInterface;
use App\Event\User\UserEvent;
use App\Repository\User\UserRepositoryInterface;
use App\Service\User\Dto\UserDto;
use App\Service\User\Factory\UserFactoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

final class UserManager implements UserManagerInterface
{
    public function __construct(
        protected UserRepositoryInterface $users,
        protected UserPasswordEncoderInterface $encoder,
        protected EntityManagerInterface $em,
        protected UserFactoryInterface $factory,
        protected EventDispatcherInterface $dispatcher,
        protected UserVerifierInterface $verifier,
        protected AvatarCreatorInterface $avatar,
    ) { }

    public function get(int $id): null|User
    {
        return $this->users->find($id);
    }

    public function getActive(int $id): null|User
    {
        return $this->users->findActive($id);
    }

    public function getAll(): array
    {
        return $this->users->findAll();
    }

    public function getAllActive(): array
    {
        return $this->users->findAllActive();
    }

    public function getByUsernameOrEmail(string $phrase): ?User
    {
        return $this->users->findByEmailOrUsername($phrase);
    }

    public function register(UserDto $dto): User
    {
        $user = $this->create($dto);
        $this->verifier->generateToken($user);
        $this->save($user);
        $this->dispatcher->dispatch((new UserEvent($user)), UserEvent::REGISTERED);

        return $user;
    }

    public function create(UserDto $dto): User
    {
        $user = $this->factory->create($dto);
        $this->dispatcher->dispatch((new UserEvent($user)), UserEvent::PRE_CREATE);
        $this->save($user);
        $this->dispatcher->dispatch((new UserEvent($user)), UserEvent::POST_CREATE);

        return $user;
    }

    public function update(UserDto $dto, User $user): User
    {
        $user = $this->factory->update($dto, $user);
        $this->dispatcher->dispatch((new UserEvent($user)), UserEvent::PRE_UPDATE);
        $this->save($user);
        $this->dispatcher->dispatch((new UserEvent($user)), UserEvent::POST_UPDATE);

        return $user;
    }

    public function delete(User $user): void
    {
        $user->setIsDeleted(true);

        $this->dispatcher->dispatch((new UserEvent($user)), UserEvent::PRE_DELETE);
        $this->save($user);
        $this->dispatcher->dispatch((new UserEvent($user)), UserEvent::POST_DELETE);
    }

    protected function save(User $user): User
    {
        $this->users->save($user);

        return $user;
    }

    public function changeAvatar(UploadedFile $file, User $user): string
    {
        $avatar = $this->avatar->newAvatar($user, $file);

        $account = $user->getAccount();

        $account->setAvatar($avatar);

        $this->users->save($user);

        return $this->avatar->resolveAvatarPath($avatar->getFilename());
    }
}
