<?php

namespace App\Repository;

use App\Entity\Post;
use App\Service\FileManagerServiceInterface;
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
    private $fileManagerService;

    public function __construct(ManagerRegistry $registry,
                                EntityManagerInterface $entityManager,
                                FileManagerServiceInterface $fileManagerService)
    {
        parent::__construct($registry, Post::class);
        $this->entityManager = $entityManager;
        $this->fileManagerService = $fileManagerService;
    }

    /**
     * @inheritDoc
     */
    public function getAllPosts(): array
    {
        return parent::findAll();
    }

    /**
     * @inheritDoc
     */
    public function getPostById(int $id): Object
    {
        return parent::find($id);
    }

    /**
     * @inheritDoc
     */
    public function setCreatePost(Post $post, ?UploadedFile $imageFile): Object
    {
        if ($imageFile) {
            $imageFilename = $this->fileManagerService->uploadPostImage($imageFile);
            $post->setImage($imageFilename);
        }

        $post->setCreatedAtValue()->setUpdatedAtValue()->setIsPublished();
        $this->entityManager->persist($post);
        $this->entityManager->flush();
        return $post;
    }

    /**
     * @inheritDoc
     */
    public function setUpdatePost(Post $post, ?UploadedFile $imageFile): Post
    {
        if ($imageFile) {
            $oldImageFilename = $post->getImage();
            if ($oldImageFilename) {
                $this->fileManagerService->removePostImage($oldImageFilename);
            }
            $imageFilename = $this->fileManagerService->uploadPostImage($imageFile);
            $post->setImage($imageFilename);
        }

        $post->setUpdatedAtValue();
        $this->entityManager->flush();
        return $post;
    }

    /**
     * @inheritDoc
     */
    public function setDeletePost(Post $post)
    {
        $oldImageFilename = $post->getImage();
        if ($oldImageFilename) {
            $this->fileManagerService->removePostImage($oldImageFilename);
        }

        $this->entityManager->remove($post);
        $this->entityManager->flush();
    }
}
