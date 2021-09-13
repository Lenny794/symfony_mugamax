<?php

namespace App\Controller;

use App\Entity\TopicComment;
use App\Form\TopicCommentType;
use App\Repository\TopicCommentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/topic/comment")
 */
class TopicCommentController extends AbstractController
{
    /**
     * @Route("/", name="topic_comment_index", methods={"GET"})
     */
    public function index(TopicCommentRepository $topicCommentRepository): Response
    {
        return $this->render('topic_comment/index.html.twig', [
            'topic_comments' => $topicCommentRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="topic_comment_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $topicComment = new TopicComment();
        $form = $this->createForm(TopicCommentType::class, $topicComment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($topicComment);
            $entityManager->flush();

            return $this->redirectToRoute('topic_comment_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('topic_comment/new.html.twig', [
            'topic_comment' => $topicComment,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="topic_comment_show", methods={"GET"})
     */
    public function show(TopicComment $topicComment): Response
    {
        return $this->render('topic_comment/show.html.twig', [
            'topic_comment' => $topicComment,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="topic_comment_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, TopicComment $topicComment): Response
    {
        $form = $this->createForm(TopicCommentType::class, $topicComment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('topic_comment_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('topic_comment/edit.html.twig', [
            'topic_comment' => $topicComment,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="topic_comment_delete", methods={"POST"})
     */
    public function delete(Request $request, TopicComment $topicComment): Response
    {
        if ($this->isCsrfTokenValid('delete'.$topicComment->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($topicComment);
            $entityManager->flush();
        }

        return $this->redirectToRoute('topic_comment_index', [], Response::HTTP_SEE_OTHER);
    }
}
