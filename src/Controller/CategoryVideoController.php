<?php

namespace App\Controller;

use App\Entity\CategoryVideo;
use App\Form\CategoryVideoType;
use App\Repository\CategoryVideoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/category/video')]
class CategoryVideoController extends AbstractController
{
    #[Route('/', name: 'category_video_index', methods: ['GET'])]
    public function index(CategoryVideoRepository $categoryVideoRepository): Response
    {
        return $this->render('category_video/index.html.twig', [
            'category_video' => $categoryVideoRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'category_video_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $categoryVideo = new CategoryVideo();
        $form = $this->createForm(CategoryVideoType::class, $categoryVideo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($categoryVideo);
            $entityManager->flush();

            return $this->redirectToRoute('category_video_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('category_video/new.html.twig', [
            'category_video' => $categoryVideo,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'category_video_show', methods: ['GET'])]
    public function show(CategoryVideo $categoryVideo): Response
    {
        return $this->render('category_video/show.html.twig', [
            'category_video' => $categoryVideo,
        ]);
    }

    #[Route('/{id}/edit', name: 'category_video_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, CategoryVideo $categoryVideo, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CategoryVideoType::class, $categoryVideo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('category_video_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('category_video/edit.html.twig', [
            'category_video' => $categoryVideo,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'category_video_delete', methods: ['POST'])]
    public function delete(Request $request, CategoryVideo $categoryVideo, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$categoryVideo->getId(), $request->request->get('_token'))) {
            $entityManager->remove($categoryVideo);
            $entityManager->flush();
        }

        return $this->redirectToRoute('category_video_index', [], Response::HTTP_SEE_OTHER);
    }
}
