<?php

namespace App\Entity\Stream;

use App\Entity\Base\AbstractEntity;
use App\Entity\User\Account;
use App\Repository\Stream\StreamManagerRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StreamManagerRepository::class)
 */
class StreamViewer extends AbstractEntity
{
    /**
     * @ORM\OneToOne(targetEntity=Stream::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    protected Account $account;

    /**
     * @ORM\OneToOne(targetEntity=Stream::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    protected Stream $stream;

    public function __construct(
        Account $account,
        Stream $stream,
    ) {
        $this->account = $account;
        $this->stream = $stream;
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

    /**
     * @return Stream
     */
    public function getStream(): Stream
    {
        return $this->stream;
    }

    /**
     * @param Stream $stream
     */
    public function setStream(Stream $stream): void
    {
        $this->stream = $stream;
    }
}
