<?php

namespace App\Entity\Stream;

use App\Entity\Base\AbstractEntity;
use App\Repository\Stream\Doctrine\StreamCategoryRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @Gedmo\Tree(type="nested")
 * @ORM\Entity(repositoryClass=StreamCategoryRepository::class)
 */
class StreamCategory extends AbstractEntity
{
    /**
     * @ORM\Column(type="string", length=120, nullable=false)
     */
    protected string $name;

    /**
     * @Gedmo\TreeLeft()
     * @ORM\Column(type="integer")
     */
    protected ?int $lft;

    /**
     * @Gedmo\TreeLevel()
     * @ORM\Column(type="integer")
     */
    protected ?int $lvl;

    /**
     * @Gedmo\TreeRight()
     * @ORM\Column(type="integer")
     */
    protected ?int $rgt;

    /**
     * @Gedmo\TreeRoot()
     * @ORM\ManyToOne(targetEntity=StreamCategory::class)
     * @ORM\JoinColumn(name="tree_root", referencedColumnName="id", onDelete="cascade")
     */
    private self $root;

    /**
     * @Gedmo\TreeParent()
     * @ORM\ManyToOne(targetEntity=StreamCategory::class)
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", onDelete="cascade")
     * @Groups({"category_data"})
     */
    private ?self $parent;

    /**
     * @ORM\OneToMany(targetEntity=StreamCategory::class, mappedBy="parent")
     * @ORM\OrderBy({"lft" = "ASC"})
     */
    private ?Collection $children;

    public function getLft(): ?int
    {
        return $this->lft;
    }

    public function getRgt(): ?int
    {
        return $this->rgt;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): void
    {
        $this->parent = $parent;
    }

    public function getRoot(): self
    {
        return $this->root;
    }

    public function getChildren(): ?Collection
    {
        return $this->children;
    }

    public function getLvl(): ?int
    {
        return $this->lvl;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
