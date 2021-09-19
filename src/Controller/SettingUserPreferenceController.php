<?php

namespace App\Controller;

use App\Entity\SettingUserPreference;
use App\Form\SettingUserPreferenceType;
use App\Repository\SettingUserPreferenceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("user")
 */
class SettingUserPreferenceController extends AbstractController
{
    /**
     * @Route("/setting", name="setting_user_preference_index", methods={"GET"})
     */
    public function index(SettingUserPreferenceRepository $settingUserPreferenceRepository): Response
    {
        return $this->render('setting_user_preference/index.html.twig', [
            'setting_user_preferences' => $settingUserPreferenceRepository->findAll(),
        ]);
    }

    /**
     * @Route("/setting/new", name="setting_user_preference_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $settingUserPreference = new SettingUserPreference();
        $form = $this->createForm(SettingUserPreferenceType::class, $settingUserPreference);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($settingUserPreference);
            $entityManager->flush();

            return $this->redirectToRoute('setting_user_preference_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('setting_user_preference/new.html.twig', [
            'setting_user_preference' => $settingUserPreference,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/setting/{id}", name="setting_user_preference_show", methods={"GET"})
     */
    public function show(SettingUserPreference $settingUserPreference): Response
    {
        return $this->render('setting_user_preference/show.html.twig', [
            'setting_user_preference' => $settingUserPreference,
        ]);
    }

    /**
     * @Route("/setting/{id}/edit", name="setting_user_preference_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, SettingUserPreference $settingUserPreference): Response
    {
        $form = $this->createForm(SettingUserPreferenceType::class, $settingUserPreference);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('setting_user_preference_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('setting_user_preference/edit.html.twig', [
            'setting_user_preference' => $settingUserPreference,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/setting/{id}", name="setting_user_preference_delete", methods={"POST"})
     */
    public function delete(Request $request, SettingUserPreference $settingUserPreference): Response
    {
        if ($this->isCsrfTokenValid('delete'.$settingUserPreference->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($settingUserPreference);
            $entityManager->flush();
        }

        return $this->redirectToRoute('setting_user_preference_index', [], Response::HTTP_SEE_OTHER);
    }
}
