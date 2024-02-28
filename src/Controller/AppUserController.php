<?php

namespace App\Controller;

use App\Entity\AppUser;
use App\Form\AppUserType;
use App\Repository\AppUserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin')]
class AppUserController extends AbstractController
{
    #[Route('/app/user/', name: 'app_user_index', methods: ['GET'])]
    public function index(AppUserRepository $appUserRepository): Response
    {
        return $this->render('app_user/index.html.twig', [
            'app_users' => $appUserRepository->findAll(),
        ]);
    }

    #[Route('/app/user/add', name: 'app_user_add', methods: ['GET', 'POST'])]
    public function add(
        Request $request,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordHasher,
    ): Response {
        $appUser = new AppUser();
        $form = $this->createForm(AppUserType::class, $appUser);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $password = $data->getPassword();
            $hashedPassword = $passwordHasher->hashPassword($appUser, $password);

            $hashedPassword = $data->setPassword($hashedPassword);

            $entityManager->persist($data);
            $entityManager->flush();

            return $this->redirectToRoute('app_user_index');
        }
        return $this->render('app_user/add.html.twig', [
            'app_user' => $appUser,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/app/user/{id}', name: 'app_user_show', methods: ['GET'])]
    public function show(AppUser $appUser): Response
    {
        return $this->render('app_user/show.html.twig', [
            'app_user' => $appUser,
        ]);
    }

    #[Route('/app/user/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, AppUser $appUser, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AppUserType::class, $appUser);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('app_user/edit.html.twig', [
            'app_user' => $appUser,
            'form' => $form,
        ]);
    }

    #[Route('/app/user/{id}/delete', name: 'app_user_delete', methods: ['GET', 'POST'])]
    public function delete(Request $request, AppUser $appUser, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($appUser);
        $entityManager->flush();

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }
}
