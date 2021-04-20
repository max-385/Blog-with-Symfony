<?php


namespace App\Controller\Admin;


use App\Entity\Post;
use App\Form\PostType;
use App\Repository\CategoryRepository;
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
     * @param CategoryRepository $categoryRepository
     * @return Response
     */
    public function index(PostRepository $postRepository, CategoryRepository $categoryRepository)
    {
        $posts = $postRepository->findAll();
        $categories = $categoryRepository->findAll();
        $forRender = parent::renderDefault();
        $forRender['posts'] = $posts;
        $forRender['categories'] = $categories;
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

    /**
     * @Route("/admin/post/update/{id}", name="admin_post_update")
     * @param int $id
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function updatePost(int $id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $post = $em->getRepository(Post::class)->find($id);
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            if($form->get('save')->isClicked()){
                $post->setUpdatedAtValue();
                $this->addFlash('success', 'Post has been updated successfully');
            }
            if($form->get('delete')->isClicked()){
                $em->remove($post);
                $this->addFlash('success', 'Post has been deleted successfully');
            }
            $em->flush();
            return $this->redirectToRoute('admin_post');
        }
        $forRender = parent::renderDefault();
        $forRender['title'] = 'Post update';
        $forRender['form'] = $form->createView();
        return $this->render('admin/post/form.html.twig', $forRender);
    }
}