<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CategoryController extends AbstractController
{
    #[Route('/category', name: 'app_category')]
    public function index(CategoryRepository $categoryRepository): Response
    {
        $categorys = $categoryRepository->findAll();
        return $this->render('category/index.html.twig', [
            'categorys' => $categorys,
        ]);
    }

    #[Route('/category/create', name: 'create_category')]
    public function create(Request $request,EntityManagerInterface $entityManager): Response
    {
        $categorys = new Category();
        $form = $this->createForm(CategoryType::class, $categorys);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $entityManager -> persist($categorys);
            $entityManager->flush();

            return $this->redirectToRoute('app_category');
        }
        $formView = $form->createView();

        return $this->render('category/create.html.twig', [
            'formView' => $formView,
            'categorys' => $categorys,
        ]);
    }
}
