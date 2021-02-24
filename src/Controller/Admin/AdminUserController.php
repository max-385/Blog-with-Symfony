<?php


namespace App\Controller\Admin;


use App\Entity\User;
use App\Form\UserType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminUserController extends AdminBaseController
{

    /**
     * @Route("/admin/users", name="admin_users")
     * @return Response
     */
    public function index()
    {
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();
        $forRender = parent::renderDefault();
        $forRender['title'] = 'Users';
        $forRender['users'] = $users;
        return $this->render('admin/User/index.html.twig', $forRender);

    }

    /**
     * @Route("/admin/users/create", name="admin_users_create")
     * @param Request $request
     * @param UserPasswordEncoderInterface $userPasswordEncoder
     * @return Response
     */
    public function create(Request $request, UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $em = $this->getDoctrine()->getManager();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $password = $userPasswordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
            $user->setRoles(['ROLE_ADMIN']);
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('admin_users');
        }
        $forRender = parent::renderDefault();
        $forRender['title'] = 'User creation form';
        $forRender['form'] = $form->createView();
        return $this->render('admin/User/form.html.twig', $forRender);
    }
}