<?php

namespace App\Controller;

use App\Entity\Flag;
use App\Entity\User;
use App\Entity\UserFlag;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class UserController extends AbstractController
{
    #[Route('/user/{user}')]
    public function profile(EntityManagerInterface $doctrine, User $user): Response
    {
        $flags = $doctrine->getRepository(Flag::class)->findAll();
        $userFlags = $doctrine->getRepository(UserFlag::class)->findBy(['user' => $user]);

        foreach ($flags as $flag) {
            foreach ($userFlags as $userFlag) {
                if ($userFlag->getFlag()->getId() === $flag->getId()) {
                    $flag->flaggedAt = $userFlag->getFlaggedAt();
                }
            }
        }

        return $this->render(
            'user/show.html.twig',
            ['user' => $user, 'flags' => $flags]
        );
    }    
}
