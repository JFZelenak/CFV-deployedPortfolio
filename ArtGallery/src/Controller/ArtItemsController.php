<?php

namespace App\Controller;

use App\Entity\ArtItems;
use App\Form\ArtItemsType;
use App\Repository\ArtItemsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/art')]
class ArtItemsController extends AbstractController
{
    #[Route('/', name: 'app_art_items_index', methods: ['GET'])]
    public function index(ArtItemsRepository $artItemsRepository): Response
    {
        return $this->render('art_items/index.html.twig', [
            'art_items' => $artItemsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_art_items_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $artItem = new ArtItems();
        $form = $this->createForm(ArtItemsType::class, $artItem);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($artItem);
            $entityManager->flush();

            return $this->redirectToRoute('app_art_items_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('art_items/new.html.twig', [
            'art_item' => $artItem,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_art_items_show', methods: ['GET'])]
    public function show(ArtItems $artItem): Response
    {
        return $this->render('art_items/show.html.twig', [
            'art_item' => $artItem,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_art_items_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ArtItems $artItem, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ArtItemsType::class, $artItem);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_art_items_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('art_items/edit.html.twig', [
            'art_item' => $artItem,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_art_items_delete', methods: ['POST'])]
    public function delete(Request $request, ArtItems $artItem, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$artItem->getId(), $request->request->get('_token'))) {
            $entityManager->remove($artItem);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_art_items_index', [], Response::HTTP_SEE_OTHER);
    }
}
