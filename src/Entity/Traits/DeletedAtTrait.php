<?php

namespace App\Entity\Traits;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

trait DeletedAtTrait
{
    /**
     * @ORM\Column(name="is_deleted", type="boolean", nullable=false)
     */
    protected bool $isDeleted = false;

    /**
     * @ORM\Column(name="deleted_at", type="datetime", nullable=true)
     */
    protected ?DateTime $deletedAt;

    /**
     * @param bool $isDeleted
     *
     * @return $this
     */
    public function setIsDeleted(bool $isDeleted): self
    {
        $this->isDeleted = $isDeleted;

        return $this;
    }

    /**
     * @return bool
     */
    public function getIsDeleted(): bool
    {
        return $this->isDeleted;
    }

    /**
     * @param DateTime $deletedAt
     *
     * @return $this
     */
    public function setDeletedAt(DateTime $deletedAt): self
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getDeletedAt(): ?DateTime
    {
        return $this->deletedAt;
    }
}
