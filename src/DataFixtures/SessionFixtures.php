<?php

namespace App\DataFixtures;

use App\Entity\Session;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class SessionFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        foreach ($this->getData() as $session) {
            $object = new Session();
            $object
                ->setName($session['name'])
                ->setIsClosed($session['is_closed'])
            ;

            foreach ($session['users'] as $user) {
                $user = $this->getReference(sprintf('%s-%s', UserFixtures::REFERENCE_PREFIX, $user));
                if ($user instanceof User) {
                    $object->addUser($user);
                }
            }

            $manager->persist($object);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
        ];
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function getData(): array
    {
        return [
            ['name' => 'Session 1', 'is_closed' => false, 'users' => []],
            ['name' => 'Session 2', 'is_closed' => true, 'users' => []],
            ['name' => 'Session 3', 'is_closed' => true, 'users' => ['admin', 'user']],
            ['name' => 'Session 4', 'is_closed' => false, 'users' => []],
        ];
    }
}
