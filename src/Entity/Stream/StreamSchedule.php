<?php

namespace App\Entity\Stream;

use App\Entity\Base\AbstractEntity;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class StreamSchedule extends AbstractEntity
{
    /**
     * @ORM\OneToOne(targetEntity=Stream::class)
     */
    protected Stream $stream;

    /**
     * @ORM\Column(name="executed", type="datetime", nullable="true")
     */
    protected ?DateTimeInterface $executed;

    public function __construct(
        Stream $stream,
    ) {
        $this->stream = $stream;
    }

    public function getStream(): Stream
    {
        return $this->stream;
    }

    public function setStream(Stream $stream): void
    {
        $this->stream = $stream;
    }

    public function getExecuted(): ?DateTimeInterface
    {
        return $this->executed;
    }

    public function setExecuted(?DateTimeInterface $executed): void
    {
        $this->executed = $executed;
    }
}
