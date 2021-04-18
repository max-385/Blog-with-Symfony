<?php


namespace App\Controller\Admin;


use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminPostController extends AdminBaseController
{
    /**
     * @Route("/admin/post", name="admin_post")\
     * @param PostRepository $postRepository
     * @return Response
     */
    public function index(PostRepository $postRepository)
    {
        $posts = $postRepository->findAll();

        $forRender = parent::renderDefault();
        $forRender['posts'] = $posts;
        $forRender['title'] = 'Posts';
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
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $post->setCreatedAtValue()->setUpdatedAtValue()->setIsPublished();
            $em->persist($post);
            $em->flush();
            $this->addFlash('success', 'A new post has been added!');
            return $this->redirectToRoute('admin_post');
        }
        $forRender = parent::renderDefault();
        $forRender['title'] = 'Post creation';
        $forRender['form'] = $form->createView();

        return $this->render('admin/post/form.html.twig', $forRender);
    }
}