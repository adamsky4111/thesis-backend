<?php

namespace App\Repository\Stream\Doctrine;

use App\Entity\Stream\StreamCategory;
use Doctrine\ORM\EntityManagerInterface;
use Gedmo\Tree\Entity\Repository\NestedTreeRepository;

class StreamCategoryRepository extends NestedTreeRepository
{
    public function __construct(EntityManagerInterface $manager)
    {
        parent::__construct($manager, $manager->getClassMetadata(StreamCategory::class));
    }

    /** @return StreamCategory[] */
    public function getAllLeafs(): array
    {
        $roots = $this->getRootNodes();
        $data = [];
        foreach ($roots as $root) {
            $data = array_merge($this->getLeafs($root), $data);
        }

        return $data;
    }

    /** @return StreamCategory[] */
    public function getAllParents(StreamCategory $category): array
    {
        return $this->getPath($category);
    }
}
