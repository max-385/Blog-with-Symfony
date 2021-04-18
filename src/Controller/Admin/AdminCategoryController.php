<?php


namespace App\Controller\Admin;



use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminCategoryController extends AdminBaseController
{
    /**
     * @Route("/admin/category", name="admin_category")\
     * @param CategoryRepository $categoryRepository
     * @return Response
     */
    public function index(CategoryRepository $categoryRepository)
    {
        $categories = $categoryRepository->findAll();

        $forRender = parent::renderDefault();
        $forRender['categories'] = $categories;
        $forRender['title'] = 'Categories';
        return $this->render('admin/category/index.html.twig', $forRender);
    }

    /**
     * @Route("/admin/category/create", name="admin_category_create")
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function createCategory(Request $request)
    {
        $category = new Category();
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $category->setCreatedAtValue()->setUpdatedAtValue();
            $em->persist($category);
            $em->flush();
            $this->addFlash('success', 'A new category has been added!');
            return $this->redirectToRoute('admin_category');
        }
        $forRender = parent::renderDefault();
        $forRender['title'] = 'Category creation';
        $forRender['form'] = $form->createView();

        return $this->render('admin/category/form.html.twig', $forRender);
    }
}