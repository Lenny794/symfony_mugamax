<?php

namespace App\Controller;
use App\Entity\TopicComment;
use App\Entity\Topic;
use App\Form\TopicType;
use App\Repository\TopicCommentRepository;
use App\Repository\TopicRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
     * @Route("/forum/{id}", name="topic_show", methods={"GET"})
     */
    public function show(Topic $topic, int $id, TopicCommentRepository $topicCommentRepository ): Response
    {   
        $topicComment = $topicCommentRepository->find($id);
        
        return $this->render('topic/show.html.twig', [
            'topic_comment' => $topicComment,
            'topic' => $topic,
        ]);
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

            return $this->redirectToRoute('topic_page', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('topic/edit.html.twig', [
            'topic' => $topic,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/forum/{id}", name="topic_delete", methods={"POST"})
     */
    public function delete(Request $request, Topic $topic): Response
    {
        if ($this->isCsrfTokenValid('delete'.$topic->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($topic);
            $entityManager->flush();
        }

        return $this->redirectToRoute('topic_page', [], Response::HTTP_SEE_OTHER);
    }
}
