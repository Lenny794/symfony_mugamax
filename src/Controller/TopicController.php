<?php

namespace App\Controller;

use App\Entity\Topic;
use App\Form\TopicType;
use App\Entity\TopicComment;
use App\Form\TopicCommentType;
use App\Repository\TopicRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/")
 */
class TopicController extends AbstractController
{
    /**
     * @Route("/forum", name="topic_index", methods={"GET"})
     */
    public function index(TopicRepository $topicRepository): Response
    {
        return $this->render('topic/index.html.twig', [
            'topics' => $topicRepository->findAll(),
        ]);
    }

    /**
     * @Route("/forum/create", name="topic_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $topic = new Topic();
        $form = $this->createForm(TopicType::class, $topic);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $topic->setUser($this->getUser());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($topic);
            $entityManager->flush();

            return $this->redirectToRoute('topic_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('topic/new.html.twig', [
            'topic' => $topic,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/forum/{id}", name="topic_show", methods={"GET","POST"}, requirements={"id":"\d+"})
     */
    public function show(Topic $topic, int $id, EntityManagerInterface $em, Request $request): Response
    {   
        $topicComment = new TopicComment();

        $form = $this->createForm(TopicCommentType::class, $topicComment);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) 
        {
            $topicComment->setTopic($topic);
            $topicComment->setUser($this->getUser());

            $em->persist($topicComment);
            $em->flush();
            return $this->redirectToRoute('topic_show', ['id' => $id]);
        }
        
        return $this->render('topic/show.html.twig', [
            'topic' => $topic,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/forum/{id}/edit_Comment", name="topic_comment_edit", methods={"GET","POST"}, requirements={"id":"\d+"})
     */
    public function editTopicComment(Request $request, TopicComment $topicComment, int $id): Response
    {
        if ($this->getUser() !== $topicComment->getUser())
        {
            $this->addFlash('message', 'Vous n\'avez pas les droits');

            return $this->redirectToRoute('topic_show', ['id' => $id], Response::HTTP_SEE_OTHER);
        }

        $form = $this->createForm(TopicCommentType::class, $topicComment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        { 
            $this->getDoctrine()->getManager()->flush();
            
            $this->addFlash('message', 'Votre commentaire a été modifier');

            return $this->redirectToRoute('topic_show', ['id' => $topicComment->getTopic()->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('topic_comment/edit.html.twig', [
            'topicComment' => ['id' => $topicComment->getId()],
            'form' => $form,
            "returnTopic" => $topicComment->getTopic()->getId()
        ]);
    }
    
    /**
     * @Route("/forum/comment/{id}/delete", name="topic_comment_delete", methods={"POST"})
     */
    public function deleteTopicComment(Request $request, TopicComment $topicComment, int $id): Response
    {
        if ($this->isCsrfTokenValid('delete'.$topicComment->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($topicComment);
            $entityManager->flush();
        }

        return $this->redirectToRoute('topic_show', ['id' => $topicComment->getTopic()->getId()], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/forum/{id}/edit", name="topic_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Topic $topic): Response
    {
        $form = $this->createForm(TopicType::class, $topic);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('topic_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('topic/edit.html.twig', [
            'topic' => $topic,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/forum/{id}/delete", name="topic_delete", methods={"POST"})
     */
    public function delete(Request $request, Topic $topic): Response
    {
        if ($this->isCsrfTokenValid('delete'.$topic->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($topic);
            $entityManager->flush();
        }

        return $this->redirectToRoute('topic_index', [], Response::HTTP_SEE_OTHER);
    }
}
