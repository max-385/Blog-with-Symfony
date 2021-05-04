<?php


namespace App\Controller\Admin;



use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use App\Repository\CategoryRepositoryInterface;
use App\Service\Category\CategoryService;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminCategoryController extends AdminBaseController
{

    private $categoryRepository;

    private $categoryService;

    public function __construct(CategoryRepositoryInterface $categoryRepository, CategoryService $categoryService)
    {
        $this->categoryRepository = $categoryRepository;
        $this->categoryService = $categoryService;
    }

    /**
     * @Route("/admin/category", name="admin_category")
     * @return Response
     */
    public function index()
    {
        $forRender = parent::renderDefault();
        $forRender['categories'] = $this->categoryRepository->getAllCategories();
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
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->categoryService->handleCreateCategory($category);
            $this->addFlash('success', 'A new category has been added!');
            return $this->redirectToRoute('admin_category');
        }
        $forRender = parent::renderDefault();
        $forRender['title'] = 'Category creation';
        $forRender['form'] = $form->createView();

        return $this->render('admin/category/form.html.twig', $forRender);
    }

    /**
     * @Route("/admin/category/update/{categoryId}", name="admin_category_update")
     * @param int $categoryId
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function updateCategory(int $categoryId, Request $request)
    {
        $category = $this->categoryRepository->getCategoryById($categoryId);
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('save')->isClicked()) {
                $this->categoryService->handleUpdateCategory($category);
                $this->addFlash('success', 'Category has been updated successfully');
            }
            if ($form->get('delete')->isClicked()) {
                $this->categoryService->handleDeleteCategory($category);
                $this->addFlash('success', 'Category has been deleted successfully');
            }
            return $this->redirectToRoute('admin_category');
        }
        $forRender = parent::renderDefault();
        $forRender['title'] = 'Category update';
        $forRender['form'] = $form->createView();
        return $this->render('admin/category/form.html.twig', $forRender);
    }


}