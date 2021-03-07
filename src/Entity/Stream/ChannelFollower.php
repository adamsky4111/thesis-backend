<?php

namespace App\Entity\Stream;

use App\Entity\Base\AbstractEntity;
use App\Entity\User\Account;
use App\Repository\Stream\ChannelFollowerRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ChannelFollowerRepository::class)
 */
class ChannelFollower extends AbstractEntity
{
    /**
     * @ORM\OneToOne(targetEntity=Stream::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    protected Account $account;

    /**
     * @ORM\OneToOne(targetEntity=Channel::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    protected Channel $channel;

    public function __construct(
        Account $account,
        Channel $channel,
    ) {
        $this->account = $account;
        $this->channel = $channel;
    }

    /**
     * @return Account
     */
    public function getAccount(): Account
    {
        return $this->account;
    }

    /**
     * @param Account $account
     */
    public function setAccount(Account $account): void
    {
        $this->account = $account;
    }

    public function getChannel(): ?Channel
    {
        return $this->channel;
    }

    public function setChannel(Channel $channel): self
    {
        $this->channel = $channel;

        return $this;
    }
}
