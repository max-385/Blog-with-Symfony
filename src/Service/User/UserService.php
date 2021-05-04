<?php


namespace App\Service\User;

use App\Entity\User;
use App\Repository\UserRepositoryInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserService
{
    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * @var UserPasswordEncoderInterface
     */
    private $userPasswordEncoder;

    public function __construct(UserRepositoryInterface $userRepository, UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $this->userRepository = $userRepository;
        $this->userPasswordEncoder = $userPasswordEncoder;
    }


    /**
     * @param User $user
     * @return $this
     */
    public function handleUserCreate(User $user)
    {
        $password = $this->userPasswordEncoder->encodePassword($user, $user->getPlainPassword());
        $user->setPassword($password);
        $user->setRoles(['ROLE_ADMIN']);

        $this->userRepository->setCreateUser($user);
        return $this;
    }

    /**
     * @param User $user
     * @return $this
     */
    public function handleUserUpdate(User $user)
    {
        $password = $this->userPasswordEncoder->encodePassword($user, $user->getPlainPassword());
        $user->setPassword($password);

        $this->userRepository->setUpdateUser($user);
        return $this;
    }
}