<?php


namespace App\Controller\Main;

use App\Repository\PostRepositoryInterface;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends BaseController
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
     * @Route("/", name="home")
     **/
    public function index()
    {
        $forRender = parent::renderDefault();
        $forRender['posts'] = $this->postRepository->getAllPosts();
        $forRender['post_filter'] = $this->postRepository->getFilterPostCategory();
        return $this->render('main/index.html.twig', $forRender);
    }
}