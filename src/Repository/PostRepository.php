<?php

namespace App\Repository;

use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository implements PostRepositoryInterface
{
    private $entityManager;

    public function __construct(ManagerRegistry $registry,
                                EntityManagerInterface $entityManager)
    {
        parent::__construct($registry, Post::class);
        $this->entityManager = $entityManager;
    }

    /**
     * @inheritDoc
     */
    public function getAllPosts(): array
    {
        $db = $this->createQueryBuilder('p')
            ->select('p.id', 'p.title', 'p.content', 'p.image', 'c.name as categoryName')
//            ->where('p.id > :id')
//            ->setParameter('id', 25)
//            ->orWhere('p.title = :title')
//            ->setParameter('title', 'Test post')
            ->leftJoin('p.category', 'c');
        $query = $db->getQuery();
        return $query->execute();

//        return parent::findAll();
    }

    /**
     * @inheritDoc
     */
    public function getPostById(int $id): ?object
    {
        return parent::find($id);
    }

    public function getFilterPostCategory(): array
    {
        $db = $this->createQueryBuilder('p')
            ->select('pc.id as categoryId', 'pc.name as categoryName')
            ->distinct()
            ->leftJoin('p.category', 'pc');

        $query = $db->getQuery();
        return $query->execute();
    }


    /**
     * @inheritDoc
     */
    public function getPostFilterJson(int $categoryId): array
    {
        $db = $this->createQueryBuilder('p')
            ->select('p.id', 'p.title', 'p.content', 'p.image', 'pc.name as categoryName')
            ->leftJoin('p.category', 'pc')
            ->where('p.category = :categoryId')
            ->setParameter('categoryId', $categoryId);

        $query = $db->getQuery();
        return $query->execute();
    }


    /**
     * @inheritDoc
     */
    public function setCreatePost(Post $post): object
    {
        $this->entityManager->persist($post);
        $this->entityManager->flush();
        return $post;
    }

    /**
     * @inheritDoc
     */
    public function setUpdatePost(Post $post): object
    {
        $this->entityManager->flush();
        return $post;
    }

    /**
     * @inheritDoc
     */
    public function setDeletePost(Post $post)
    {
        $this->entityManager->remove($post);
        $this->entityManager->flush();
    }
}
