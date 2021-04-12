<?php

namespace App\Entity\User;

use App\Repository\User\Doctrine\SettingsRepository;
use App\Entity\Base\AbstractEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SettingsRepository::class)
 */
class Media extends AbstractEntity
{
    const IMAGE = 'img';
    const VIDEO = 'vid';

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     */
    protected User $owner;

    /**
     * @ORM\Column(name="filename", type="string", length=120)
     */
    protected string $filename;

    /**
     * @ORM\Column(name="original_filename", type="string", length=120)
     */
    protected string $originalFilename;

    /**
     * @ORM\Column(name="size", type="string", length=120)
     */
    protected string $size;

    /**
     * @ORM\Column(name="type", type="string", length=120)
     */
    protected string $type;

    /**
     * @return User
     */
    public function getOwner(): User
    {
        return $this->owner;
    }

    /**
     * @param User $owner
     */
    public function setOwner(User $owner): void
    {
        $this->owner = $owner;
    }

    /**
     * @return string
     */
    public function getFilename(): string
    {
        return $this->filename;
    }

    /**
     * @return string
     */
    public function getOriginalFilename(): string
    {
        return $this->originalFilename;
    }

    /**
     * @param string $originalFilename
     */
    public function setOriginalFilename(string $originalFilename): void
    {
        $this->originalFilename = $originalFilename;
    }

    /**
     * @param string $filename
     */
    public function setFilename(string $filename): void
    {
        $this->filename = $filename;
    }

    /**
     * @return string
     */
    public function getSize(): string
    {
        return $this->size;
    }

    /**
     * @param string $size
     */
    public function setSize(string $size): void
    {
        $this->size = $size;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }
}
