<?php

namespace App\Controller;

use App\Repository\CategoryNewsRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoryPublicController extends AbstractController
{
    /**
     * @Route("/Actualité", name="public_category_list", methods={"GET"})
     */
    public function index(CategoryNewsRepository $categoryNewsRepository): Response
    {
        return $this->render('category_public/list.html.twig', [
            'category_news' => $categoryNewsRepository->findAll(),
        ]);
    }
    /**
     * @Route("/Actualité/détail/{id}", name="public_category_detail", methods={"GET"})
     */
    public function detail(int $id,CategoryNewsRepository $categoryNewsRepository): Response
    {
        $category = $categoryNewsRepository->find($id);

        return $this->render('category_public/detail.html.twig', [
            'category' => $category,
        ]);
    }
}