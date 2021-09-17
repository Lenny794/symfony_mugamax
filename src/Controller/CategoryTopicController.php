<?php

namespace App\Controller;

use App\Entity\CategoryTopic;
use App\Form\CategoryTopicType;
use App\MesServices\HandleIcon;
use App\Repository\CategoryTopicRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin")
 */
class CategoryTopicController extends AbstractController
{
    /**
     * @Route("/category/topic/liste", name="category_topic_index", methods={"GET"})
     */
    public function index(CategoryTopicRepository $categoryTopicRepository): Response
    {
        return $this->render('category_topic/index.html.twig', [
            'category_topics' => $categoryTopicRepository->findAll(),
        ]);
    }

    /**
     * @Route("/category/topic/create", name="category_topic_new", methods={"GET","POST"})
     */
    public function new(Request $request, SluggerInterface $slugger, HandleIcon $handleIcon): Response
    {
        $categoryTopic = new CategoryTopic();
        $form = $this->createForm(CategoryTopicType::class, $categoryTopic);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $iconFile = $form->get('image_path_url')->getData();

            if($iconFile)
            {
                $handleIcon->SaveImage($iconFile, $categoryTopic);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($categoryTopic);
            $entityManager->flush();

            return $this->redirectToRoute('category_topic_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('category_topic/new.html.twig', [
            'category_topic' => $categoryTopic,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/category/topic/{id}", name="category_topic_show", methods={"GET"})
     */
    public function show(CategoryTopic $categoryTopic): Response
    {
        return $this->render('category_topic/show.html.twig', [
            'category_topic' => $categoryTopic,
        ]);
    }

    /**
     * @Route("/category/topic/{id}/edit", name="category_topic_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, CategoryTopic $categoryTopic, HandleIcon $handleIcon): Response
    {
        $form = $this->createForm(CategoryTopicType::class, $categoryTopic);
        $form->handleRequest($request);

        $vintageImage = $categoryTopic->getImagePathUrl();

        if ($form->isSubmitted() && $form->isValid()) {

            $iconFile = $form->get('image_path_url')->getData();
            
            if($iconFile)
            {
               $handleIcon->editImage($iconFile, $categoryTopic, $vintageImage); 
                          
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('category_topic_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('category_topic/edit.html.twig', [
            'category_topic' => $categoryTopic,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/category/topic/{id}", name="category_topic_delete", methods={"POST"})
     */
    public function delete(Request $request, CategoryTopic $categoryTopic, HandleIcon $handleIcon): Response
    {
        if ($this->isCsrfTokenValid('delete'.$categoryTopic->getId(), $request->request->get('_token'))) 
        {
            $vintageImage = $categoryTopic->getImagePathUrl();
            
            $handleIcon->deleteImage($vintageImage);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($categoryTopic);
            $entityManager->flush();
        }

        return $this->redirectToRoute('category_topic_index', [], Response::HTTP_SEE_OTHER);
    }
}
