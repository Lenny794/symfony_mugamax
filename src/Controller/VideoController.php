<?php

namespace App\Controller;

use App\Entity\Video;
use App\Form\VideoType;
use App\MesServices\HandleImage;
use App\Repository\VideoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/')]
class VideoController extends AbstractController
{
    #[Route('/video', name: 'video_index', methods: ['GET'])]
    public function index(VideoRepository $videoRepository): Response
    {
        return $this->render('video/index.html.twig', [
            'videos' => $videoRepository->findAll(),
        ]);
    }

    #[Route('/admin/video/new', name: 'video_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger, HandleImage $handleImage): Response
    {
        $video = new Video();
        $video->setCreatedAt(new \DateTime('now'));
        $form = $this->createForm(VideoType::class, $video);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $imageFile = $form->get('image')->getData();
            $video->setUser($this->getUser());
            if ($imageFile) {
                $handleImage->saveImage($imageFile, $video);
            }            

            $entityManager->persist($video);
            $entityManager->flush();

            return $this->redirectToRoute('video_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('video/new.html.twig', [
            'video' => $video,
            'form' => $form,
        ]);
    }

    #[Route('/video/{id}', name: 'video_show', methods: ['GET'])]
    public function show(Video $video): Response
    {
        return $this->render('video/show.html.twig', [
            'video' => $video,
        ]);
    }

    #[Route('/admin/video/{id}/edit', name: 'video_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Video $video, EntityManagerInterface $entityManager, HandleImage $handleImage): Response
    {
        $form = $this->createForm(VideoType::class, $video);
        $form->handleRequest($request);

        $vintageImage = $video->getImage();

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $imageFile = $form->get('image')->getData();

            if ($imageFile) {
                $handleImage->editImage($imageFile, $video, $vintageImage);
            }

            $entityManager->flush();

            return $this->redirectToRoute('video_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('video/edit.html.twig', [
            'video' => $video,
            'form' => $form,
        ]);
    }

    #[Route('/admin/video/{id}', name: 'video_delete', methods: ['POST'])]
    public function delete(Request $request, Video $video, EntityManagerInterface $entityManager, HandleImage $handleImage): Response
    {
        if ($this->isCsrfTokenValid('delete'.$video->getId(), $request->request->get('_token'))) 
        {
            $vintageImage = $video->getImage();

            $handleImage->deleteImage($vintageImage);

            $entityManager->remove($video);
            $entityManager->flush();
        }

        return $this->redirectToRoute('video_index', [], Response::HTTP_SEE_OTHER);
    }
}
