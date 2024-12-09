<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventType;
use App\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EventController extends AbstractController
{
    #[Route('/event', name: 'app_event')]
    public function index(EventRepository $eventRepository): Response
    {
        $events = $eventRepository->findAll();
        return $this->render('event/index.html.twig', [
            'events' => $events,
        ]);
    }

    #[Route('/event/create', name: 'create_event')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $events = new Event();
        $form = $this->createForm(EventType::class, $events);
        $form->handleRequest($request);


        if ($form->isSubmitted()) {
            $entityManager->persist($events);
            $entityManager->flush();

            return $this->redirectToRoute('app_event');
        }

        $formView = $form->createView();
        return $this->render('event/create.html.twig', [
            'events' => $events,
            'formView' => $formView,
        ]);
    }

    #[Route('/event/{id}/show', name: 'show_event')]
    public function show(Event $event, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {

            $entityManager->persist($event);

            $entityManager->flush();

            return $this->redirectToRoute('app_event');

        }

        $formView = $form->createView();

        return $this->render('event/show.html.twig', [
            'event' => $event,
            'formView' => $formView,
        ]);
    }
}
