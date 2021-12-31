<?php

namespace App\Entity\Stream;

use App\Entity\Base\AbstractEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class StreamTag extends AbstractEntity
{
    /**
     * @ORM\Column(type="string", length=120, nullable=false)
     */
    protected string $name;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
