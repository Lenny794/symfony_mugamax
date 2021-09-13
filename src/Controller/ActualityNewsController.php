<?php

namespace App\Controller;

use App\Entity\ActualityNews;
use App\Form\ActualityNewsType;
use App\Repository\ActualityNewsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/actuality/news")
 */
class ActualityNewsController extends AbstractController
{
    /**
     * @Route("/", name="actuality_news_index", methods={"GET"})
     */
    public function index(ActualityNewsRepository $actualityNewsRepository): Response
    {
        return $this->render('actuality_news/index.html.twig', [
            'actuality_news' => $actualityNewsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="actuality_news_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $actualityNews = new ActualityNews();
        $form = $this->createForm(ActualityNewsType::class, $actualityNews);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($actualityNews);
            $entityManager->flush();

            return $this->redirectToRoute('actuality_news_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('actuality_news/new.html.twig', [
            'actuality_news' => $actualityNews,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="actuality_news_show", methods={"GET"})
     */
    public function show(ActualityNews $actualityNews): Response
    {
        return $this->render('actuality_news/show.html.twig', [
            'actuality_news' => $actualityNews,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="actuality_news_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ActualityNews $actualityNews): Response
    {
        $form = $this->createForm(ActualityNewsType::class, $actualityNews);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('actuality_news_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('actuality_news/edit.html.twig', [
            'actuality_news' => $actualityNews,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="actuality_news_delete", methods={"POST"})
     */
    public function delete(Request $request, ActualityNews $actualityNews): Response
    {
        if ($this->isCsrfTokenValid('delete'.$actualityNews->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($actualityNews);
            $entityManager->flush();
        }

        return $this->redirectToRoute('actuality_news_index', [], Response::HTTP_SEE_OTHER);
    }
}
