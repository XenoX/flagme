<?php

namespace App\Controller;

use DateTimeImmutable;
use App\Entity\Flag;
use App\Entity\User;
use App\Entity\UserFlag;
use App\Form\FlagType;
use App\Repository\FlagRepository;
use App\Repository\UserFlagRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class AppController extends AbstractController
{
    #[Route('/')]
    public function index(EntityManagerInterface $doctrine, Request $request): Response
    {
        if (!$session = $this->getUser()->getSession()) {
            return $this->render('app/noSession.html.twig');
        }

        $form = $this->createForm(FlagType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $flag = $form->get('value')->getData();

            if (!$flagExist = $doctrine->getRepository(Flag::class)->findOneBy(['value' => $flag])) {
                $this->addFlash('danger', 'This flag doesn\'t exist.');

                return $this->redirectToRoute('app_app_index');
            }

            if (
                $userFlagExist = $doctrine->getRepository(UserFlag::class)
                    ->findOneBy(['flag' => $flagExist, 'user' => $this->getUser()])
            ) {
                $this->addFlash('danger', 'This flag has already been added.');

                return $this->redirectToRoute('app_app_index');
            }

            $userFlag = new UserFlag();
            $userFlag
                ->setUser($this->getUser())
                ->setFlag($flagExist)
                ->setFlaggedAt((new DateTimeImmutable()))
            ;

            $doctrine->persist($userFlag);
            $doctrine->flush();

            $this->addFlash('success', 'Congrats, you add a flag !');
        }

        $users = $doctrine->getRepository(User::class)->findBy(['session' => $session]);
        $flags = $doctrine->getRepository(Flag::class)->findAll();

        usort($users, fn($a, $b) => $a->getUserFlags()->count() < $b->getUserFlags()->count());

        return $this->render(
            'app/index.html.twig',
            ['users' => $users, 'flags' => $flags, 'form' => $form->createView()],
        );
    }
}
