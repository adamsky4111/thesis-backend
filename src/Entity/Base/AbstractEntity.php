<?php

namespace App\Entity\Base;

use App\Entity\Traits\DeletedAtTrait;
use App\Entity\Traits\UpdatedAtTrait;
use Doctrine\ORM\Mapping as ORM;

abstract class AbstractEntity
{
    use DeletedAtTrait,
        UpdatedAtTrait;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected ?int $id;

    public function getId(): ?int
    {
        return $this->id;
    }
}
