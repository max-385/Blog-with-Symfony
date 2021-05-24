<?php


namespace App\Service\Post;


use App\Entity\Post;
use App\Repository\PostRepositoryInterface;
use App\Service\FileManagerServiceInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class PostService
{
    /**
     * @var PostRepositoryInterface
     */
    private $postRepository;
    /**
     * @var FileManagerServiceInterface
     */
    private $fileManagerService;

    public function __construct(PostRepositoryInterface $postRepository, FileManagerServiceInterface $fileManagerService)
    {
        $this->postRepository = $postRepository;
        $this->fileManagerService = $fileManagerService;
    }

    /**
     * @param Post $post
     * @param UploadedFile|null $imageFile
     */
    public function handleCreatePost(Post $post, ?UploadedFile $imageFile)
    {
        if ($imageFile) {
            $imageFilename = $this->fileManagerService->uploadPostImage($imageFile);
            $post->setImage($imageFilename);
        }

        $post->setCreatedAtValue()->setUpdatedAtValue()->setIsPublished();

        $this->postRepository->setCreatePost($post);
    }
}