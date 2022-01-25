<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use DateTimeImmutable;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\UserFlag;
use App\Entity\Flag;
use App\Form\FlagType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\FlagRepository;

class FlagController extends AbstractController
{
    #[Route('/flag')]
    public function add(Request $request, EntityManagerInterface $doctrine): Response
    {
        $form = $this->createForm(FlagType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $flag = $form->get('value')->getData();

            if (!$flagExist = $doctrine->getRepository(Flag::class)->findOneBy(['value' => $flag])) {
                $this->addFlash('danger', 'Ce flag n\'existe pas.');

                return $this->redirectToRoute('app_flag_add');
            }

            if (
                $userFlagExist = $doctrine->getRepository(UserFlag::class)
                    ->findOneBy(['flag' => $flagExist, 'user' => $this->getUser()])
            ) {
                $this->addFlash('danger', 'Ce flag est déjà ajouté.');

                return $this->redirectToRoute('app_flag_add');
            }

            $userFlag = new UserFlag();
            $userFlag
                ->setUser($this->getUser())
                ->setFlag($flagExist)
                ->setFlaggedAt((new DateTimeImmutable()))
            ;

            $doctrine->persist($userFlag);
            $doctrine->flush();

            $this->addFlash('success', 'Félicitations, tu as ajouté un flag !');
        }

        return $this->render('flag/add.html.twig', ['form' => $form->createView()]);
    }
}
