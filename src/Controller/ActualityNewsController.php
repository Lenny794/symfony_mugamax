<?php

namespace App\Controller;

use App\Entity\ActualityNews;
use App\Form\ActualityNewsType;
use App\Entity\ActualityComment;
use App\MesServices\HandleImage;
use App\Form\ActualityCommentType;
use App\Repository\ActualityCommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ActualityNewsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * @Route("/")
 */
class ActualityNewsController extends AbstractController
{
    /**
     * @Route("/actuality", name="actuality_news_index", methods={"GET"})
     */
    public function index(ActualityNewsRepository $actualityNewsRepository): Response
    {
        return $this->render('actuality_news/index.html.twig', [
            'actuality_news' => $actualityNewsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/admin/actuality/create", name="actuality_news_new", methods={"GET","POST"}, requirements={"id":"\d+"})
     */
    public function new(Request $request, SluggerInterface $slugger, HandleImage $handleImage): Response
    {
        $actualityNews = new ActualityNews();
        $form = $this->createForm(ActualityNewsType::class, $actualityNews);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $actualityNews->setUser($this->getUser());

            $imageFile = $form->get('image')->getData();

            if ($imageFile) {
                $handleImage->saveImage($imageFile, $actualityNews);
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
     * @Route("/actuality/{id}", name="actuality_news_show", methods={"GET","POST"}, requirements={"id":"\d+"})
     */
    public function show(ActualityNews $actualityNews, Request $request, EntityManagerInterface $em, int $id): Response
    {
        $actualityComment = new ActualityComment();

        $form = $this->createForm(ActualityCommentType::class, $actualityComment);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $actualityComment->setActualityNews($actualityNews);
            $actualityComment->setUser($this->getUser());

            $em->persist($actualityComment);
            $em->flush();
            return $this->redirectToRoute('actuality_news_show', ['id' => $id]);
        }
        return $this->render('actuality_news/show.html.twig', [
            'actuality_news' => $actualityNews,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/actuality/comment/{id}/edit/", name="actuality_comment_edit", methods={"GET","POST"}, requirements={"id":"\d+"})
     */
    public function editComment(ActualityComment $actualityComment, Request $request, int $id): Response
    {
        $form = $this->createForm(ActualityCommentType::class, $actualityComment);

        $form->handleRequest($request);

        if ($this->getUser() !== $actualityComment->getUser()) {
            $this->addFlash('message', 'Vous n\'avez pas les droits');

            return $this->redirectToRoute('topic_show', ['id' => $id], Response::HTTP_SEE_OTHER);
        }
        if ($form->isSubmitted() && $form->isValid()) {

            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('message', 'Votre commentaire a ??t?? modifi??');

            return $this->redirectToRoute('actuality_news_show', ['id' => $actualityComment->getActualityNews()->getId()], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('actuality_news/edit_comment.html.twig', [
            'actuality_news' => ['id' => $actualityComment->getId()],
            'form' => $form,
            "returnActuality" => $actualityComment->getActualityNews()->getId()
        ]);
    }

    /**
     * @Route("/admin/actuality/{id}/edit", name="actuality_news_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ActualityNews $actualityNews, HandleImage $handleImage): Response
    {
        $form = $this->createForm(ActualityNewsType::class, $actualityNews);
        $form->handleRequest($request);

        $vintageImage = $actualityNews->getImage();

        if ($form->isSubmitted() && $form->isValid()) {

            $imageFile = $form->get('image')->getData();

            if ($imageFile) {
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
     * @Route("/actuality/comment/{id}/delete", name="actuality_comment_delete", methods={"POST"})
     */
    public function deleteActualityComment(Request $request, ActualityComment $actualityComment, int $id): Response
    {
        if ($this->isCsrfTokenValid('delete' . $actualityComment->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($actualityComment);
            $entityManager->flush();
        }

        return $this->redirectToRoute('actuality_news_show', ['id' => $actualityComment->getActualityNews()->getId()], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("admin/actuality/news/{id}", name="actuality_news_delete", methods={"POST"})
     */
    public function delete(Request $request, ActualityNews $actualityNews, HandleImage $handleImage): Response
    {
        if ($this->isCsrfTokenValid('delete' . $actualityNews->getId(), $request->request->get('_token'))) {
            $vintageImage = $actualityNews->getImage();

            $handleImage->deleteImage($vintageImage);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($actualityNews);
            $entityManager->flush();
        }

        return $this->redirectToRoute('actuality_news_index', [], Response::HTTP_SEE_OTHER);
    }
}
