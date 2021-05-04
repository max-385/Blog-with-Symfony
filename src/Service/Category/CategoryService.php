<?php


namespace App\Service\Category;


use App\Entity\Category;
use App\Repository\CategoryRepositoryInterface;

class CategoryService
{
    /**
     * @var CategoryRepositoryInterface
     */
    private $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {

        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @param Category $category
     * @return $this
     */
    public function handleCreateCategory(Category $category)
    {
        $category->setCreatedAtValue()->setUpdatedAtValue();

        $this->categoryRepository->setCreateCategory($category);

        return $this;
    }


    /**
     * @param Category $category
     * @return $this
     */
    public function handleUpdateCategory(Category $category)
    {
        $category->setUpdatedAtValue();

        $this->categoryRepository->setUpdateCategory($category);

        return $this;
    }

    /**
     * @param Category $category
     */
    public function handleDeleteCategory(Category $category)
    {
        $this->categoryRepository->setDeleteCategory($category);
    }
}