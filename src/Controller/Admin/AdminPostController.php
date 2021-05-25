<?php


namespace App\Controller\Admin;


use App\Entity\Post;
use App\Form\PostType;
use App\Repository\CategoryRepository;
use App\Repository\PostRepository;
use App\Service\Post\PostService;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminPostController extends AdminBaseController
{
    private $categoryRepository;
    private $postRepository;
    private $postService;

    /**
     * AdminPostController constructor.
     * @param CategoryRepository $categoryRepository
     * @param PostRepository $postRepository
     * @param PostService $postService
     */
    public function __construct(CategoryRepository $categoryRepository, PostRepository $postRepository,
                                PostService $postService)
    {
        $this->categoryRepository = $categoryRepository;
        $this->postRepository = $postRepository;
        $this->postService = $postService;
    }

    /**
     * @Route("/admin/post", name="admin_post")\
     * @return Response
     */
    public function index()
    {
        $forRender = parent::renderDefault();
        $forRender['title'] = 'Posts';
        $forRender['posts'] = $this->postRepository->getAllPosts();
        $forRender['categories'] = $this->categoryRepository->getAllCategories();
        return $this->render('admin/post/index.html.twig', $forRender);
    }

    /**
     * @Route("/admin/post/create", name="admin_post_create")
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function createPost(Request $request)
    {
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->postService->handleCreatePost($post, $form);
            $this->addFlash('success', 'A new post has been added!');
            return $this->redirectToRoute('admin_post');
        }
        $forRender = parent::renderDefault();
        $forRender['title'] = 'Post creation';
        $forRender['form'] = $form->createView();

        return $this->render('admin/post/form.html.twig', $forRender);
    }

    /**
     * @Route("/admin/post/update/{postId}", name="admin_post_update")
     * @param int $postId
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function updatePost(int $postId, Request $request)
    {
        $post = $this->postRepository->getPostById($postId);
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('save')->isClicked()) {
                $this->postService->handleUpdatePost($post, $form);
                $this->addFlash('success', 'Post has been updated successfully');
            }
            if ($form->get('delete')->isClicked()) {
                $this->postService->handleDeletePost($post);
                $this->addFlash('success', 'Post has been deleted successfully');
            }
            return $this->redirectToRoute('admin_post');
        }
        $forRender = parent::renderDefault();
        $forRender['title'] = 'Post update';
        $forRender['form'] = $form->createView();
        return $this->render('admin/post/form.html.twig', $forRender);
    }
}