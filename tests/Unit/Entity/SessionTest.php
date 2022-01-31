<?php

namespace App\Tests\Entity;

use App\Entity\Session;
use App\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;

class SessionTest extends TestCase
{  
    public function testGettersAndSettersAndToString(): void
    {
        $session = new Session();

        $this->assertInstanceOf(ArrayCollection::class, $session->getUsers());
        $this->assertNull($session->getId());

        $session
             ->setName('SESSION_TEST')
             ->setIsClosed(true)
        ;

        $this->assertSame('SESSION_TEST', $session->getName());
        $this->assertSame(true, $session->getIsClosed());

        $this->assertEquals('SESSION_TEST', $session->__toString());
    } 

    public function testUsers()
    {
        $session = new Session();
        $user = $this->createMock(User::class);

        $user->expects($this->once())->method('getSession')->with()->willReturn($session);
        $user->expects($this->exactly(2))->method('setSession')->WithConsecutive([$session], [null]);

        $session->addUser($user);
        $this->assertNotEmpty($session->getUsers());
        $this->assertSame(1, $session->getUsers()->count());

        $session->removeUser($user);
        $this->assertEmpty($session->getUsers());
    }
}
