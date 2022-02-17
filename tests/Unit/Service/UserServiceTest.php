<?php

namespace App\Tests\Service;

use App\Entity\User;
use App\Service\UserService;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserServiceTest extends TestCase
{
    private MockObject|EntityManagerInterface $manager;
    private MockObject|UserPasswordHasherInterface $hasher;

    protected function setUp(): void
    {
        $this->manager = $this->createMock(EntityManagerInterface::class);
        $this->hasher = $this->createMock(UserPasswordHasherInterface::class);
    }

    public function testCreateShouldReturnUserObject()
    {
        $this->hasher->expects($this->once())->method('hashPassword')
            ->with(self::anything(), 'password')->willReturn('encodedPassword');
        $this->manager->expects($this->once())->method('persist');
        $this->manager->expects($this->once())->method('flush');

        $service = new UserService($this->manager, $this->hasher);
        $object = $service->create('PhpUnit', 'password', 'ROLE_ADMIN');

        $this->assertInstanceOf(User::class, $object);
        $this->assertSame(['ROLE_ADMIN', 'ROLE_USER'], $object->getRoles());
        $this->assertSame('encodedPassword', $object->getPassword());
        $this->assertSame('PhpUnit', $object->getUsername());
    }
}
