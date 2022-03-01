<?php

namespace App\Controller;

use App\Repository\TopicRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TopicPublicController extends AbstractController
{
    /**
     * @Route("/mes-posts", name="public_topic_list", methods={"GET"})
     */
    public function index(TopicRepository $topicRepository): Response
    {
        $user = $this->getUser();
        return $this->render('topic_public/list.html.twig', [
            'topics' => $topicRepository->findAll(),
            'user' => $user,
        ]);
    }

}