<?php

namespace App\core;

use Doctrine\ORM\QueryBuilder;


class PaginationModel
{
    private array $items;
    private int $currentPage;
    private int $totalPages;
    private int $totalItems;
    private int $pageSize;

    public function __construct(array $items, int $totalItems, int $pageSize, int $currentPage)
    {
        $this->items = $items;
        $this->totalItems = $totalItems;
        $this->pageSize = $pageSize;
        $this->currentPage = $currentPage;
        $this->totalPages = (int) ceil($totalItems / $pageSize);

        // If the currentPage exceeds totalPages, set it to totalPages
        if ($this->currentPage > $this->totalPages) {
            $this->currentPage = $this->totalPages;
        }
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function getCurrentPage(): int
    {
        return $this->currentPage;
    }

    public function getTotalPages(): int
    {
        return $this->totalPages;
    }

    public function getTotalItems(): int
    {
        return $this->totalItems;
    }

    public function getPageSize(): int
    {
        return $this->pageSize;
    }

    public function hasPreviousPage(): bool
    {
        return $this->currentPage > 1;
    }

    public function hasNextPage(): bool
    {
        return $this->currentPage < $this->totalPages;
    }

    public static function paginate(QueryBuilder $queryBuilder, int $pageSize, int $currentPage): self
    {
        // Get total number of items using Doctrine's count method
        $totalItems = $queryBuilder->select('e')->getQuery()->getResult();
        $totalItems = count($totalItems); // Get the total count of items

        // Paginate the items
        $items = $queryBuilder
            ->setFirstResult(($currentPage - 1) * $pageSize)
            ->setMaxResults($pageSize)
            ->getQuery()
            ->getResult();

        return new self($items, $totalItems, $pageSize, $currentPage);
    }
}

