<?php

namespace App\Controller;

use App\Entity\CategoryNews;
use App\Form\CategoryNewsType;
use App\Repository\CategoryNewsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/category/news")
 */
class CategoryNewsController extends AbstractController
{
    /**
     * @Route("/", name="category_news_index", methods={"GET"})
     */
    public function index(CategoryNewsRepository $categoryNewsRepository): Response
    {
        return $this->render('category_news/index.html.twig', [
            'category_news' => $categoryNewsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="category_news_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $categoryNews = new CategoryNews();
        $form = $this->createForm(CategoryNewsType::class, $categoryNews);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($categoryNews);
            $entityManager->flush();

            return $this->redirectToRoute('category_news_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('category_news/new.html.twig', [
            'category_news' => $categoryNews,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="category_news_show", methods={"GET"})
     */
    public function show(CategoryNews $categoryNews): Response
    {
        return $this->render('category_news/show.html.twig', [
            'category_news' => $categoryNews,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="category_news_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, CategoryNews $categoryNews): Response
    {
        $form = $this->createForm(CategoryNewsType::class, $categoryNews);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('category_news_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('category_news/edit.html.twig', [
            'category_news' => $categoryNews,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="category_news_delete", methods={"POST"})
     */
    public function delete(Request $request, CategoryNews $categoryNews): Response
    {
        if ($this->isCsrfTokenValid('delete'.$categoryNews->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($categoryNews);
            $entityManager->flush();
        }

        return $this->redirectToRoute('category_news_index', [], Response::HTTP_SEE_OTHER);
    }
}
