<?php

namespace App\Controller;

use App\Entity\Animator;
use App\Form\AnimatorType;
use App\Repository\AnimatorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AnimatorController extends AbstractController
{
    #[Route('/animator', name: 'app_animator')]
    public function index(AnimatorRepository $animatorRepository): Response
    {

        $animators = $animatorRepository->findAll();
        return $this->render('animator/index.html.twig', compact('animators'));
    }

    #[Route('/animator/create', name: 'animator_create')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {


        $animator = new Animator();
        $form = $this->createForm(AnimatorType::class, $animator);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $entityManager->persist($animator);
            $entityManager->flush();

            return $this->redirectToRoute('app_animator');

        }
        $formView = $form->createView();
        return $this->render('animator/create.html.twig', [
            'formView' => $formView,
            'animator' => $animator,
        ]);
    }
}
