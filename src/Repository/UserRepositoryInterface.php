<?php


namespace App\Repository;


use App\Entity\User;

interface UserRepositoryInterface
{
    /**
     * @param User $user
     * @return User
     */
    public function setCreateUser(User $user): object;

    /**
     * @param User $user
     * @return User
     */
    public function setUpdateUser(User $user): object;

    /**
     * @return User[]
     */
    public function getAllUsers(): array;

    /**
     * @param int $userId
     * @return User;
     */
    public function getOneUser(int $userId): object;
}