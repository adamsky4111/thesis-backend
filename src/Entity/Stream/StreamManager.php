<?php

namespace App\Entity\Stream;

use App\Entity\Base\AbstractEntity;
use App\Entity\User\Account;
use App\Repository\Stream\StreamManagerRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StreamManagerRepository::class)
 */
class StreamManager extends AbstractEntity
{
    /**
     * @ORM\OneToOne(targetEntity=Account::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    protected Account $account;

    /**
     * @ORM\Column(type="json")
     */
    protected iterable $rules = [];

    /**
     * @ORM\ManyToOne(targetEntity=StreamManagement::class, inversedBy="managers")
     */
    private StreamManagement $management;

    public function __construct(
        Account $account,
        StreamManagement $management,
        iterable $rules = [],
    ) {
        $this->account = $account;
        $this->management = $management;
        $this->rules = $rules;
    }

    public function getAccount(): ?Account
    {
        return $this->account;
    }

    public function setAccount(Account $account): self
    {
        $this->account = $account;

        return $this;
    }

    public function getRules(): ?iterable
    {
        return $this->rules;
    }

    public function setRules(array $rules): self
    {
        $this->rules = $rules;

        return $this;
    }

    public function hasRule(string $rule): bool
    {
        return in_array($rule, $this->rules);
    }

    public function addRule(string $rule): self
    {
        $this->rules[] = $rule;

        return $this;
    }

    public function removeRule(string $rule): self
    {
        if ($this->hasRule($rule)) {
            $this->rules = array_diff($this->rules, [$rule]);
        }

        return $this;
    }

    public function getManagement(): ?StreamManagement
    {
        return $this->management;
    }

    public function setManagement(StreamManagement $management): self
    {
        $this->management = $management;

        return $this;
    }
}
