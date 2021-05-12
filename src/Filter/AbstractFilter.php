<?php

namespace App\Filter;


abstract class AbstractFilter implements FilterInterface
{
    protected int $perPage = 10;
    protected int $page = 1;
    protected int $limit = 0;
    protected bool $paginated = true;
    protected array $sortBy = [];
    protected array $findBy = [];

    public function calculateOffset(): int
    {
        return $this->getPage() >= 1
            ? (($this->getPage() * $this->getPerPage()) - $this->getPerPage())
            : 0;
    }

    /**
     * @return int
     */
    public function getPerPage(): int
    {
        return $this->perPage;
    }

    /**
     * @param int $perPage
     */
    public function setPerPage(int $perPage): void
    {
        $this->perPage = $perPage;
    }

    /**
     * @return int
     */
    public function getPage(): int
    {
        return $this->page;
    }

    /**
     * @param int $page
     */
    public function setPage(int $page): void
    {
        $this->page = $page;
    }

    /**
     * @return int
     */
    public function getLimit(): int
    {
        return $this->limit;
    }

    /**
     * @param int $limit
     */
    public function setLimit(int $limit): void
    {
        $this->limit = $limit;
    }

    public function getLike(string $phrase): string
    {
        return '%'.preg_replace('/(?<!\\\)([%_])/', '\\\$1',$phrase).'%';
    }

    /**
     * @return bool
     */
    public function isPaginated(): bool
    {
        return $this->paginated;
    }

    /**
     * @param bool $paginated
     */
    public function setPaginated(bool $paginated): void
    {
        $this->paginated = $paginated;
    }

    /**
     * @return array
     */
    public function getSortBy(): array
    {
        return $this->sortBy;
    }

    /**
     * @param array $sortBy
     */
    public function setSortBy(array $sortBy): void
    {
        $this->sortBy = $sortBy;
    }

    /**
     * @return array
     */
    public function getFindBy(): array
    {
        return $this->findBy;
    }

    /**
     * @param array $findBy
     */
    public function setFindBy(array $findBy): void
    {
        $this->findBy = $findBy;
    }
}

