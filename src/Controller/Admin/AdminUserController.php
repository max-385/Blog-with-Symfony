<?php


namespace App\Controller\Admin;


use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepositoryInterface;
use App\Service\User\UserService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminUserController extends AdminBaseController
{


    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * @var UserService
     */
    private $userService;

    public function __construct(UserRepositoryInterface $userRepository, UserService $userService)
    {
        $this->userRepository = $userRepository;
        $this->userService = $userService;
    }

    /**
     * @Route("/admin/users", name="admin_users")
     * @return Response
     */
    public function index()
    {
        $forRender = parent::renderDefault();
        $forRender['title'] = 'Users';
        $forRender['users'] = $this->userRepository->getAllUsers();
        return $this->render('admin/User/index.html.twig', $forRender);

    }

    /**
     * @Route("/admin/users/create", name="admin_users_create")
     * @param Request $request
     * @return Response
     */
    public function create(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->userService->handleUserCreate($user);
            $this->addFlash('success', 'New User has been added!');
            return $this->redirectToRoute('admin_users');
        }
        $forRender = parent::renderDefault();
        $forRender['title'] = 'User creation form';
        $forRender['form'] = $form->createView();
        return $this->render('admin/User/form.html.twig', $forRender);
    }


    /**
     * @Route("/admin/users/update/{userId}", name="admin_users_update")
     * @param Request $request
     * @param int $userId
     * @return Response
     */
    public function update(Request $request, int $userId)
    {
        $user = $this->userRepository->getOneUser($userId);
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->userService->handleUserUpdate($user);
            $this->addFlash('success', 'User data has been updated successfully');
            return $this->redirectToRoute('admin_users');
        }

        $forRender = parent::renderDefault();
        $forRender['title'] = 'User update';
        $forRender['form'] = $form->createView();
        return $this->render('admin/User/form.html.twig', $forRender);
    }
}