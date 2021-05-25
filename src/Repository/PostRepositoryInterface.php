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
     * @return Post|null
     */
    public function getPostById(int $id): ?object;


    /**
     * @param Post $post
     * @return Post
     */
    public function setCreatePost(Post $post): object;


    /**
     * @param Post $post
     * @return Post
     */
    public function setUpdatePost(Post $post): object;


    /**
     * @param Post $post
     */
    public function setDeletePost(Post $post);


}