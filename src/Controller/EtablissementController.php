<?php

namespace App\Controller;

use App\Entity\Etablissement;
use App\Form\EtablissementType;
use App\Repository\EtablissementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EtablissementController extends AbstractController
{
    #[Route('/etablissement', name: 'app_etablissement')]
    public function index(EtablissementRepository $etablissementRepository): Response
    {

        $etablissements = $etablissementRepository->findAll();
        return $this->render('etablissement/index.html.twig', [
            'etablissements' => $etablissements,
        ]);
    }
#[Route('/etablissement/create', name: 'create_etablissement')]
    public function create(Request $request, EntityManagerInterface $entityManager) : Response
    {
        $etablissement = new Etablissement();
        $form = $this->createForm(EtablissementType::class, $etablissement);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            $entityManager->persist($etablissement);
            $entityManager->flush();

            return $this->redirectToRoute('app_etablissement');
        }
        $formView = $form->createView();

        return $this->render('etablissement/create.html.twig', [
            'etablissement' => $etablissement,
            'formView' => $formView,
        ]);
    }

    #[Route('/etablissement/{id}/delete', name: 'delete_etablissement')]
    public function delete(Request $request, Etablissement $etablissement, EntityManagerInterface $entityManager): Response

    {
        $image = $form ->get('image')->getData();

            $entityManager->remove($etablissement);
            $entityManager->flush();

            $this->addFlash('Success', ':)');

        return $this->redirectToRoute('app_etablissement');

        return $this ->render('etablissement/delete.html.twig', [
            'etablissement' => $etablissement,
        ]);
    }


}
