<?php

namespace App\DataFixtures;

use App\Entity\Flag;
use App\Entity\User;
use App\Entity\UserFlag;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class UserFlagFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        foreach ($this->getData() as $userFlag) {
            $user = $this->getReference(sprintf('%s-%s', UserFixtures::REFERENCE_PREFIX, $userFlag['user']));
            $flag = $this->getReference(sprintf('%s-%s', FlagFixtures::REFERENCE_PREFIX, $userFlag['flag']));

            if ($user instanceof User && $flag instanceof Flag) {
                $object = (new UserFlag())
                    ->setUser($user)
                    ->setFlag($flag)
                ;

                $manager->persist($object);
            }
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
            FlagFixtures::class,
        ];
    }

    /**
    * @return array<int, array<string, mixed>>
    */
    private function getData(): array
    {
        return [
            ['user' => 'admin', 'flag' => 'xss'],
            ['user' => 'user', 'flag' => 'ssti'],
        ];
    }
}
