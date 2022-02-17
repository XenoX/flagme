<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserService
{
    public function __construct(
        private EntityManagerInterface $manager,
        private UserRepository $userRepository,
        private UserPasswordHasherInterface $hasher,
    ) {
    }

    public function create(string $username, string $plainPassword, string $role): User
    {
        if ($user = $this->userRepository->findOneBy(['username' => $username])) {
            return $user;
        }

        $user = new User();
        $user
            ->setUsername($username)
            ->setPassword($this->hasher->hashPassword($user, $plainPassword))
            ->setRoles([$role])
        ;

        $this->manager->persist($user);
        $this->manager->flush();

        return $user;
    }
}