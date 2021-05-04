<?php


namespace App\Repository;


use App\Entity\Category;

interface CategoryRepositoryInterface
{
    /**
     * @return Category[]
     */
    public function getAllCategories(): array;

    /**
     * @param int $id
     * @return Category
     */
    public function getCategoryById(int $id): object;

    /**
     * @param Category $category
     * @return CategoryRepositoryInterface
     */
    public function setCreateCategory(Category $category): self;

    /**
     * @param Category $category
     * @return CategoryRepositoryInterface
     */
    public function setUpdateCategory(Category $category): self;

    /**
     * @param Category $category
     */
    public function setDeleteCategory(Category $category);
}