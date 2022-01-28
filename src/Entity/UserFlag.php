<?php

namespace App\Entity;

use App\Repository\UserFlagRepository;
use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserFlagRepository::class)]
class UserFlag
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'userFlags')]
    #[ORM\JoinColumn(nullable: true)]
    private ?UserInterface $user;

    #[ORM\ManyToOne(targetEntity: Flag::class, inversedBy: 'userFlags')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Flag $flag;

    #[ORM\Column(type: 'datetime_immutable')]
    private DateTimeInterface $flaggedAt;

    public function __construct()
    {
        $this->flaggedAt = new DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?UserInterface
    {
        return $this->user;
    }

    public function setUser(?UserInterface $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getFlag(): ?Flag
    {
        return $this->flag;
    }

    public function setFlag(?Flag $flag): self
    {
        $this->flag = $flag;

        return $this;
    }

    public function getFlaggedAt(): ?DateTimeInterface
    {
        return $this->flaggedAt;
    }

    public function setFlaggedAt(DateTimeInterface $flaggedAt): self
    {
        $this->flaggedAt = $flaggedAt;

        return $this;
    }
}
