<?php

namespace App\Entity\User;

use App\Enum\UserRoleEnum;
use App\Repository\User\Doctrine\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\User\Base\AbstractUser as BaseUser;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User extends BaseUser
{
    /**
     * @ORM\OneToOne(targetEntity=Account::class, mappedBy="user", cascade={"persist", "remove"})
     */
    protected ?Account $account;

    public function __construct()
    {
        $this->setRoles([UserRoleEnum::ROLE_USER]);
        $this->setIsActive(false);
    }

    public function getAccount(): ?Account
    {
        return $this->account;
    }

    public function setAccount(Account $account): self
    {
        if ($account->getUser() !== $this) {
            $account->setUser($this);
        }

        $this->account = $account;

        return $this;
    }
}
