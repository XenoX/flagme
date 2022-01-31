<?php

namespace App\Tests\Entity;

use App\Entity\Flag;
use App\Entity\UserFlag;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;

class FlagTest extends TestCase
{
    public function testGettersAndSetters(): void
    {
        $flag = new Flag();

        $this->assertInstanceOf(ArrayCollection::class, $flag->getUserFlags());
        $this->assertNull($flag->getId());

        $flag
            ->setName('test')
            ->setValue('TEST_VALUE')
        ;

        $this->assertSame('test', $flag->getName());
        $this->assertSame('TEST_VALUE', $flag->getValue());
    }

    public function testUserFlags()
    {
        $flag = new Flag();
        $userFlag = $this->createMock(UserFlag::class);

        $userFlag->expects($this->once())->method('getFlag')->with()->willReturn($flag);
        $userFlag->expects($this->exactly(2))->method('setFlag')->withConsecutive([$flag], [null]);

        $flag->addUserFlag($userFlag);
        $this->assertNotEmpty($flag->getUserFlags());
        $this->assertSame(1, $flag->getUserFlags()->count());

        $flag->removeUserFlag($userFlag);
        $this->assertEmpty($flag->getUserFlags());
    }
}
