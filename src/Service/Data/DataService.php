<?php


namespace App\Service\Data;


use App\Repository\PostRepositoryInterface;
use Symfony\Component\HttpFoundation\Request;

class DataService
{

    /**
     * @var PostRepositoryInterface
     */
    private $postRepository;

    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }


    /**
     * @param Request $request
     * @return array
     */
    public function getFilterPost(Request $request): array
    {
        $categoryId = $request->get('categoryId');

        return $this->postRepository->getPostFilterJson((int)$categoryId);
    }

}