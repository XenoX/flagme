<?php

namespace App\Entity;

use App\Repository\FlagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FlagRepository::class)]
class Flag
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 45)]
    private string $name;

    #[ORM\Column(type: 'string', length: 45)]
    private string $value;

    #[ORM\OneToMany(mappedBy: 'flag', targetEntity: UserFlag::class)]
    private Collection $userFlags;

    public function __construct()
    {
        $this->userFlags = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return Collection|UserFlag[]
     */
    public function getUserFlags(): Collection
    {
        return $this->userFlags;
    }

    public function addUserFlag(UserFlag $userFlag): self
    {
        if (!$this->userFlags->contains($userFlag)) {
            $this->userFlags[] = $userFlag;
            $userFlag->setFlag($this);
        }

        return $this;
    }

    public function removeUserFlag(UserFlag $userFlag): self
    {
        if ($this->userFlags->removeElement($userFlag)) {
            // set the owning side to null (unless already changed)
            if ($userFlag->getFlag() === $this) {
                $userFlag->setFlag(null);
            }
        }

        return $this;
    }
}
