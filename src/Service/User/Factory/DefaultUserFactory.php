<?php

namespace App\Service\User\Factory;

use App\Entity\User\Account;
use App\Entity\User\User;
use App\Service\User\Dto\UserDto;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

final class DefaultUserFactory implements UserFactoryInterface
{
    public function __construct(
        private UserPasswordEncoderInterface $encoder,
        private EntityManagerInterface $em,
    ) {}

    public function create(UserDto $dto): User
    {
        $user = new User();
        $user->setEmail(strtolower($dto->getEmail()))
            ->setEmailCanonical($dto->getEmail())
            ->setUsername(strtolower($dto->getUsername()))
            ->setUsernameCanonical($dto->getUsername())
            ->setIsActive(false)
            ->setPassword($this->encoder->encodePassword($user, $dto->getPlainPassword()))
            ->setIsDeleted(false);
        $this->em->persist($user);

        $account = new Account($user);
        $accountInfo = $account->getAccountInformation();
        $accountInfo->setFirstName($dto->getFirstName())
            ->setLastName($dto->getLastName())
            ->setAbout($dto->getAbout())
            ->setCountry($dto->getCountry())
            ->setNick($dto->getNick());

        $this->em->persist($account);
        $this->em->persist($accountInfo);

        return $user;
    }
}
