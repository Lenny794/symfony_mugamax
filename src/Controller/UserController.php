<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\User\EditPasswordType;
use App\Form\UserType;
use App\Form\EditProfilType;
use App\MesServices\HandleAvatar;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/profil", name="user_index", methods={"GET"})
     */
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            
        ]);
    }

    /**
     * @Route("/profil/edit", name="user_profil_edit", methods={"GET","POST"})
     */
    public function editUser(Request $request,HandleAvatar $handleAvatar): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(EditProfilType::class, $user);
        $form->handleRequest($request);

        $vintageImage = $user->getAvatarUser();

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            
            $avatarFile = $form->get('avatar_user')->getData();
            
            if($avatarFile)
            {
               $handleAvatar->editImage($avatarFile, $user, $vintageImage); 
                          
            }
            $entityManager->flush();
            
            $this->addFlash('message', 'Profil mis à jour');
            return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/edit_index.html.twig', [
           'user' => $user,
           'form' => $form,
        ]);
    }
    
    /**
     * @Route("/{id}", name="user_delete", methods={"POST"})
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('index', [], Response::HTTP_SEE_OTHER);
    }
        
    /**
     * @Route("/Security", name="user_security", methods={"GET"})
     */
    public function securityindex(UserRepository $userRepository): Response
    {
        return $this->render('user/pass_email_user.html.twig', [
            
        ]);
    }
    /**
       * @Route("/Security/edit", name="user_security_edit", methods={"GET","POST"})
       */
      public function editPasswordMail(Request $request): Response
      {
        $user = $this->getUser();
        $form = $this->createForm(EditPasswordType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            
            $entityManager->flush();
            
            $this->addFlash('message', 'Profil mis à jour');
            return $this->redirectToRoute('user_security', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/edit_pass_email.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
      }
}
