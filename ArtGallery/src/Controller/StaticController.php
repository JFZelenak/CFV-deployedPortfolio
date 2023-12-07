<?php

namespace App\Controller;

use App\Repository\ArtItemsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StaticController extends AbstractController
{
    #[Route('/', name: 'app_static')]
    public function index(ArtItemsRepository $artItemsRepository): Response
    {
        return $this->render('static/index.html.twig', [
            'controller_name' => 'StaticController',
            'art_items' => $artItemsRepository->findAll(),
        ]);
    }
}
