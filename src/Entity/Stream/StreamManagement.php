<?php

namespace App\Entity\Stream;

use App\Entity\Base\AbstractEntity;
use App\Repository\Stream\StreamManagementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StreamManagementRepository::class)
 */
class StreamManagement extends AbstractEntity
{
    /**
     * @ORM\OneToMany(targetEntity=StreamManager::class, mappedBy="management")
     */
    private iterable $managers;

    public function __construct()
    {
        $this->managers = new ArrayCollection();
    }

    /**
     * @return Collection|StreamManager[]
     */
    public function getManagers(): Collection
    {
        return $this->managers;
    }

    public function addManager(StreamManager $manager): self
    {
        if (!$this->managers->contains($manager)) {
            $this->managers[] = $manager;
            $manager->setManagement($this);
        }

        return $this;
    }

    public function removeManager(StreamManager $manager): self
    {
        if ($this->managers->removeElement($manager)) {
            // set the owning side to null (unless already changed)
            if ($manager->getManagement() === $this) {
                $manager->setManagement(null);
            }
        }

        return $this;
    }
}
