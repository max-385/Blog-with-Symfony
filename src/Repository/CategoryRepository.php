<?php

namespace App\Repository;

use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Category|null find($id, $lockMode = null, $lockVersion = null)
 * @method Category|null findOneBy(array $criteria, array $orderBy = null)
 * @method Category[]    findAll()
 * @method Category[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryRepository extends ServiceEntityRepository implements CategoryRepositoryInterface
{
    private $entityManager;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $entityManager)
    {
        parent::__construct($registry, Category::class);
        $this->entityManager = $entityManager;
    }


    /**
     * @inheritDoc
     */
    public function getAllCategories(): array
    {
        return parent::findAll();
    }

    /**
     * @inheritDoc
     */
    public function getCategoryById($id): object
    {
        return parent::find($id);
    }

    /**
     * @inheritDoc
     */
    public function setCreateCategory(Category $category): CategoryRepositoryInterface
    {
        $this->entityManager->persist($category);
        $this->entityManager->flush();
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setUpdateCategory(Category $category): CategoryRepositoryInterface
    {
        $this->entityManager->flush();
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setDeleteCategory(Category $category)
    {
        $this->entityManager->remove($category);
        $this->entityManager->flush();
    }
}
