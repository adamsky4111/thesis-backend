<?php

namespace App\Entity\User;

use App\Entity\Base\EntityInterface;
use App\Repository\User\Doctrine\SettingsRepository;
use App\Entity\Base\AbstractEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SettingsRepository::class)
 */
class Settings extends AbstractEntity implements EntityInterface
{
    /**
     * @ORM\Column(name="name", type="string", length=120)
     */
    protected string $name;

    /**
     * @ORM\Column(name="is_default", type="boolean")
     */
    protected bool $isDefault;

    /**
     * @ORM\Column(name="age_allowed", type="string", length=3)
     */
    private string $ageAllowed;

    /**
     * @ORM\ManyToOne(targetEntity=Account::class, inversedBy="settings")
     */
    protected ?Account $account;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getIsDefault(): ?bool
    {
        return $this->isDefault;
    }

    public function setIsDefault(bool $isDefault): self
    {
        $this->isDefault = $isDefault;

        return $this;
    }

    public function getAgeAllowed(): ?string
    {
        return $this->ageAllowed;
    }

    public function setAgeAllowed(string $ageAllowed): self
    {
        $this->ageAllowed = $ageAllowed;

        return $this;
    }

    public function getAccount(): ?Account
    {
        return $this->account;
    }

    public function setAccount(?Account $account): void
    {
        $this->account = $account;
    }
}
