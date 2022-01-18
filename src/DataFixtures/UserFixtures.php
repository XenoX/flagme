<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public const REFERENCE_PREFIX = 'user';

    public function __construct(private UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        foreach ($this->getData() as $user) {
            $object = new User();
            $object
                ->setUsername($user['username'])
                ->setPassword($this->hasher->hashPassword($object, $user['password']))
                ->setRoles($user['roles'])
            ;

            $this->addReference(sprintf('%s-%s', UserFixtures::REFERENCE_PREFIX, $user['username']), $object);

            $manager->persist($object);
        }

        $manager->flush();
    }

    /**
     * @return array<int, array<string, mixed>>
    */
    private function getData(): array
    {
        return [
            ['username' => 'admin', 'password' => 'admin', 'roles' => ['ROLE_ADMIN']],
            ['username' => 'user', 'password' => 'user', 'roles' => ['ROLE_USER']],
        ];
    }
}
