<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CGUController extends AbstractController
{
    #[Route('/conditions-generales-utilisation/termes-et-conditions', name: 'c_g_u')]
    public function index(): Response
    {
        return $this->render('cgu/index.html.twig', [
            'controller_name' => 'CGUController',
        ]);
    }

    #[Route('/conditions-generales-utilisation/politique-de-confidentialite', name: 'c_g_u_pdc')]
    public function pdcIndex(): Response
    {
        return $this->render('cgu/pdc_index.html.twig', [
            'controller_name' => 'CGUController',
        ]);
    }
    #[Route('/conditions-generales-utilisation/documentation', name: 'c_g_u_doc')]
    public function docIndex(): Response
    {
        return $this->render('cgu/doc_index.html.twig', [
            'controller_name' => 'CGUController',
        ]);
    }
}
