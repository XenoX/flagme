<?php

namespace App\Tests\Entity;

use App\Entity\Flag;
use App\Entity\User;
use App\Entity\UserFlag;
use Doctrine\Common\Collections\ArrayCollection;
use DateTimeImmutable;
use DateTimeInterface;
use PHPUnit\Framework\TestCase;

class UserFlagTest extends TestCase
{
    public function testGettersAndSetters()
    {
        $userFlag = new UserFlag();
        $user = $this->createMock(User::class);
        $flag = $this->createMock(Flag::class);

        $this->assertInstanceOf(DateTimeImmutable::class, $userFlag->getFlaggedAt());
        $this->assertNull($userFlag->getId());

        $userFlag
            ->setUser($user)
            ->setFlag($flag)
            ->setFlaggedAt((new DateTimeImmutable()));
        ;

        $this->assertSame($user, $userFlag->getUser());
        $this->assertSame($flag, $userFlag->getFlag());
    }
}

