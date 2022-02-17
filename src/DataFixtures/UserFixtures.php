<?php

namespace App\DataFixtures;

use App\Service\UserService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public const REFERENCE_PREFIX = 'user';

    public function __construct(private UserService $userService)
    {
    }

    public function load(ObjectManager $manager): void
    {
        foreach ($this->getData() as $user) {
            $object = $this->userService->create($user['username'], $user['password'], $user['roles']);

            $this->addReference(sprintf('%s-%s', UserFixtures::REFERENCE_PREFIX, $user['username']), $object);
        }
    }

    /**
     * @return array<int, array<string, mixed>>
    */
    private function getData(): array
    {
        return [
            ['username' => 'admin', 'password' => 'admin', 'roles' => 'ROLE_ADMIN'],
            ['username' => 'user', 'password' => 'user', 'roles' => 'ROLE_USER'],
        ];
    }
}
