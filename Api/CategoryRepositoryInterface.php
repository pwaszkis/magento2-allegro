<?php

namespace Macopedia\Allegro\Api;

use Macopedia\Allegro\Api\Data\CategoryInterface;
use Macopedia\Allegro\Model\Api\ClientException;
use Magento\Framework\Exception\NoSuchEntityException;

interface CategoryRepositoryInterface
{

    /**
     * @return CategoryInterface[]
     * @throws ClientException
     */
    public function getRootList(): array;

    /**
     * @param string $parentCategoryId
     * @return CategoryInterface[]
     * @throws ClientException
     */
    public function getList(string $parentCategoryId): array;

    /**
     * @param string $categoryId
     * @return CategoryInterface
     * @throws ClientException
     * @throws NoSuchEntityException
     */
    public function get(string $categoryId): CategoryInterface;

    /**
     * @param string $categoryId
     * @return CategoryInterface[]
     * @throws ClientException
     * @throws NoSuchEntityException
     */
    public function getAllParents(string $categoryId): array;
}
