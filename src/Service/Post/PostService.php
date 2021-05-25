<?php


namespace App\Service\Post;


use App\Entity\Post;
use App\Repository\PostRepositoryInterface;
use App\Service\FileManagerServiceInterface;
use Symfony\Component\Form\FormInterface;

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
     * @param FormInterface $form
     */
    public function handleCreatePost(Post $post, FormInterface $form)
    {
        $imageFile = $form->get('image')->getData();

        if ($imageFile) {
            $imageFilename = $this->fileManagerService->uploadPostImage($imageFile);
            $post->setImage($imageFilename);
        }

        $post->setCreatedAtValue()->setUpdatedAtValue()->setIsPublished();

        $this->postRepository->setCreatePost($post);
    }


    /**
     * @param Post $post
     * @param FormInterface $form
     */
    public function handleUpdatePost(Post $post, FormInterface $form)
    {
        $imageFile = $form->get('image')->getData();

        if ($imageFile) {
            $oldImageFilename = $post->getImage();
            if ($oldImageFilename) {
                $this->fileManagerService->removePostImage($oldImageFilename);
            }
            $imageFilename = $this->fileManagerService->uploadPostImage($imageFile);
            $post->setImage($imageFilename);
        }

        $post->setUpdatedAtValue();
        $this->postRepository->setUpdatePost($post);
    }


    public function handleDeletePost(Post $post)
    {
        $oldImageFilename = $post->getImage();
        if ($oldImageFilename) {
            $this->fileManagerService->removePostImage($oldImageFilename);
        }
        $this->postRepository->setDeletePost($post);
    }

}