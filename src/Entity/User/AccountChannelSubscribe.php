<?php

namespace App\Entity\User;

use App\Entity\Base\AbstractEntity;
use App\Entity\Stream\Channel;
use App\Entity\Traits\CreatedAtTrait;
use App\Entity\Traits\UpdatedAtTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class AccountChannelSubscribe extends AbstractEntity
{
    use CreatedAtTrait,
        UpdatedAtTrait;

    /**
     * @ORM\ManyToOne(targetEntity=Channel::class)
     */
    protected Channel $channel;

    /**
     * @ORM\ManyToOne(targetEntity=Account::class, inversedBy="registration")
     */
    protected ?Account $account;

    public function getChannel(): Channel
    {
        return $this->channel;
    }

    public function setChannel(Channel $channel): void
    {
        $this->channel = $channel;
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
