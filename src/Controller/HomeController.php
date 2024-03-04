<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', []);
    }

    #[Route('/admin', name: 'index_admin')]
    public function admin(): Response
    {
        return $this->render('admin/index.html.twig', []);
    }

}
