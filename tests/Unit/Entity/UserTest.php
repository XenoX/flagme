<?php

namespace App\Tests\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use App\Entity\User;
use App\Entity\Session;
use App\Entity\UserFlag;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testGettersAndSettersAndToString()
    {
        $user = new User();
        $session = $this->createMock(Session::class);

        $this->assertInstanceOf(ArrayCollection::class, $user->getUserFlags());
        $this->assertNull($user->getId());

        $user
            ->setUsername('allan')
            ->setPassword('allan')
            ->setRoles([])
            ->setSession($session)
        ;

        $this->assertSame('allan', $user->getUsername());
        $this->assertSame('allan', $user->getPassword());
        $this->assertSame('allan', $user->__toString());
        $this->assertSame('allan', $user->getUserIdentifier());
        $this->assertSame(['ROLE_USER'], $user->getRoles());
        $this->assertNotEmpty($user->getSession());
        $this->assertNull($user->eraseCredentials());
    }

    public function testUserFlag(){

        $user = new User();
        $userFlag = $this->createMock(UserFlag::class);

        $userFlag->expects($this->once())->method('getUser')->with()->willReturn($user);
        $userFlag->expects($this->exactly(2))->method('setUser')->withConsecutive([$user], [null]);
        
        $user->addUserFlag($userFlag);
        $this->assertNotEmpty($user->getUserFlags());
        $this->assertSame(1, $user->getUserFlags()->count());
        
        $user->removeUserFlag($userFlag);
        $this->assertEmpty($user->getUserFlags());
    }
}
