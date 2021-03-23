<?php

namespace App\Entity\User;

use App\Entity\Base\AbstractEntity;
use App\Repository\User\Doctrine\AccountInformationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AccountInformationRepository::class)
 */
class AccountInformation extends AbstractEntity
{
    /**
     * @ORM\OneToOne(targetEntity=Account::class, mappedBy="accountInformation", cascade={"persist", "remove"})
     */
    protected Account $account;

    /**
     * @ORM\Column(type="string", length=120, nullable=true)
     */
    protected string $firstName;

    /**
     * @ORM\Column(type="string", length=120, nullable=true)
     */
    protected string $lastName;

    /**
     * @ORM\Column(type="string", length=120, nullable=true)
     */
    protected string $nick;

    /**
     * @ORM\Column(type="string", length=12, nullable=true)
     */
    protected string $country;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected string $about;

    public function getAccount(): ?Account
    {
        return $this->account;
    }

    public function setAccount(Account $account): self
    {
        if ($account->getAccountInformation() !== $this) {
            $account->setAccountInformation($this);
        }

        $this->account = $account;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getNick(): ?string
    {
        return $this->nick;
    }

    public function setNick(string $nick): self
    {
        $this->nick = $nick;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getAbout(): ?string
    {
        return $this->about;
    }

    public function setAbout(string $about): self
    {
        $this->about = $about;

        return $this;
    }
}
