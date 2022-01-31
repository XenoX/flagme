<?php

namespace App\EventSubscriber;

use App\Entity\Session;
use App\Entity\User;
use App\Repository\UserRepository;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class EasyAdminSubscriber implements EventSubscriberInterface
{
    public function __construct(private UserRepository $userRepository, private UserPasswordHasherInterface $hasher)
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            BeforeEntityPersistedEvent::class => ['handlePrePersist'],
            BeforeEntityUpdatedEvent::class => ['handleUsersOnUpdate'],
        ];
    }

    public function handlePrePersist(BeforeEntityPersistedEvent $event): void
    {
        $object = $event->getEntityInstance();

        if ($object instanceof User) {
            $this->cryptPasswordOnUser($object);

            return;
        }

        if ($object instanceof Session) {
            $this->setSessionOnUsers($object);

            return;
        }
    }

    public function handleUsersOnUpdate(BeforeEntityUpdatedEvent $event): void
    {
        $session = $event->getEntityInstance();
        if (!$session instanceof Session) {
            return;
        }

        foreach ($this->userRepository->findBy(['session' => $session]) as $user) {
            $user->setSession(null);
        }

        /** @var User $user */
        foreach ($session->getUsers() as $user) {
            $user->setSession($session);
        }
    }

    private function cryptPasswordOnUser(User $user): void
    {
        $user->setPassword($this->hasher->hashPassword($user, $user->getPassword()));
    }

    private function setSessionOnUsers(Session $session): void
    {
        foreach ($session->getUsers() as $user) {
            $user->setSession($session);
        }
    }
}
