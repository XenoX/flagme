<?php

namespace App\EventSubscriber;

use App\Entity\Session;
use App\Entity\User;
use App\Repository\UserRepository;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class EasyAdminSubscriber implements EventSubscriberInterface
{
    public function __construct(private UserRepository $userRepository)
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            BeforeEntityPersistedEvent::class => ['handleUsersOnCreate'],
            BeforeEntityUpdatedEvent::class => ['handleUsersOnUpdate'],
        ];
    }

    public function handleUsersOncreate(BeforeEntityPersistedEvent $event): void
    {
        $session = $event->getEntityInstance();
        if (!$session instanceof Session) {
            return;
        }

        /** @var User $user */
        foreach ($session->getUsers() as $user) {
            $user->setSession($session);
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
}
