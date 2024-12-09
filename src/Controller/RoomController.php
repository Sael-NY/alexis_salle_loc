<?php

namespace App\Controller;


use App\Entity\Image;
use App\Entity\Room;
use App\Form\RoomType;
use App\Repository\RoomRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RoomController extends AbstractController
{
    #[Route('/room', name: 'app_room')]
    public function index(RoomRepository $roomRepository): Response
    {
        $rooms = $roomRepository->findAll();
        return $this->render('room/index.html.twig', [
            'rooms' => $rooms,
        ]);
    }

    #[Route('/room/create', name: 'create_room')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $room = new Room();
        $form = $this->createForm(RoomType::class, $room);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $images= $form->get('images') -> getData();

            foreach ($images as $image) {
                $fileName = md5(uniqid()) . '.' . $image->guessExtension();
                $image->move(
                    $this->getParameter('uploads_directory'),
                    $fileName
                );

                $image = new Image();
                $image->setPath($this ->getParameter('uploads_base_url') . '/' . $fileName);
                $image->setRoom($room);

                $entityManager->persist($image);
            }

            $entityManager->persist($room);
            $entityManager->flush();


            return $this->redirectToRoute('app_room');
        }

        $formView = $form->createView();

        return $this->render('room/create.html.twig', [
            'formView' => $formView,
            'room' => $room,
        ]);
    }

    #[Route('/room/{id}', name: 'show_room')]
    public function show(Room $room): Response
    {
        return $this->render('room/show.html.twig', [
            'room' => $room,
        ]);


    }

    #[Route('/room/{id}/edit', name: 'edit_room')]

public function edit(Request $request, Room $room, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RoomType::class, $room);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $entityManager->flush();

            $this->addFlash('Success');
            return $this->redirectToRoute('app_room');
        }

        return $this->render('room/edit.html.twig', [
            'room' => $room,
            'form' => $form,
        ]);
    }

    #[Route('/room/{id}/delete', name: 'delete_room')]
public function delete(Request $request, Room $room, EntityManagerInterface $entityManager): Response

    {
        if ($this->isCsrfTokenValid('delete'.$room->getId(), $request->request->get('_token'))) {
            foreach ($room->getImages() as $image) {
                $exploded = explode('/', $image->getPath());
                $fileName = end($exploded);
                @unlink($this->getParameter('uploads_directory') . '/' . $fileName);
            }


            $entityManager->remove($room);
            $entityManager->flush();

            $this->addFlash('Success', 'coucou');


        }

        return $this->redirectToRoute('app_room');
    }
}
