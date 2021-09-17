<?php

namespace App\Controller;

use App\Entity\ActualityNews;
use App\Form\ActualityNewsType;
use App\MesServices\HandleImage;
use App\Repository\ActualityNewsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * @Route("/")
 */
class ActualityNewsController extends AbstractController
{
    /**
     * @Route("/actuality/liste", name="actuality_news_index", methods={"GET"})
     */
    public function index(ActualityNewsRepository $actualityNewsRepository): Response
    {
        return $this->render('actuality_news/index.html.twig', [
            'actuality_news' => $actualityNewsRepository->findAll(),
        ]);
    }

    /**
     * @Route("admin/actuality/news/create", name="actuality_news_new", methods={"GET","POST"})
     */
    public function new(Request $request, SluggerInterface $slugger, HandleImage $handleImage): Response
    {
        $actualityNews = new ActualityNews();
        $form = $this->createForm(ActualityNewsType::class, $actualityNews);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {   
            $imageFile = $form->get('image')->getData();

            if($imageFile)
            {
                $handleImage->SaveImage($imageFile, $actualityNews);
            }
            
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
     * @Route("/actuality/news/{id}", name="actuality_news_show", methods={"GET"})
     */
    public function show(ActualityNews $actualityNews): Response
    {
        return $this->render('actuality_news/show.html.twig', [
            'actuality_news' => $actualityNews,
        ]);
    }

    /**
     * @Route("admin/actuality/news/{id}/edit", name="actuality_news_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ActualityNews $actualityNews, HandleImage $handleImage): Response
    {
        $form = $this->createForm(ActualityNewsType::class, $actualityNews);
        $form->handleRequest($request);

        $vintageImage = $actualityNews->getImage();
        
        if ($form->isSubmitted() && $form->isValid()) {
            
            $imageFile = $form->get('image')->getData();
            
            if($imageFile)
            {
               $handleImage->editImage($imageFile, $actualityNews, $vintageImage); 
                          
            }
            
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('actuality_news_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('actuality_news/edit.html.twig', [
            'actuality_news' => $actualityNews,
            'form' => $form,
        ]);
    }

    /**
     * @Route("admin/actuality/news/{id}", name="actuality_news_delete", methods={"POST"})
     */
    public function delete(Request $request, ActualityNews $actualityNews, HandleImage $handleImage): Response
    {
        if ($this->isCsrfTokenValid('delete'.$actualityNews->getId(), $request->request->get('_token'))) 
        {  
            $vintageImage = $actualityNews->getImage();
            
            $handleImage->deleteImage($vintageImage);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($actualityNews);
            $entityManager->flush();
        }

        return $this->redirectToRoute('actuality_news_index', [], Response::HTTP_SEE_OTHER);
    }
}
