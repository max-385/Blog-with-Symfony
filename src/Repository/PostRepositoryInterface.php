<?php


namespace App\Repository;


use App\Entity\Post;
use Symfony\Component\HttpFoundation\File\UploadedFile;

interface PostRepositoryInterface
{
    /**
     * @return Post[]
     */
    public function getAllPosts(): array;


    /**
     * @param int $id
     * @return Post
     */
    public function getPostById(int $id): object;


    /**
     * @param Post $post
     * @param UploadedFile $imageFile
     * @return Post
     */
    public function setCreatePost(Post $post, UploadedFile $imageFile): Object;


    /**
     * @param Post $post
     * @param UploadedFile $imageFile
     * @return Post
     */
    public function setUpdatePost(Post $post, UploadedFile $imageFile): Post;


    /**
     * @param Post $post
     */
    public function setDeletePost(Post $post);


}