<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private UserRepository $userRepository;

    public function __construct(EntityManagerInterface $entityManager, UserRepository $userRepository)
    {
        $this->entityManager = $entityManager;
        $this->userRepository = $userRepository;
    }

    #[Route('/user/create', name: 'app_user_create', methods: ['GET', 'POST'])]
    public function create(Request $request): Response
    {
        if ($request->isMethod('POST')) {
            // Récupérer le login et le mot de passe du formulaire
            $login = $request->request->get('login');
            $password = $request->request->get('password');

            // Vérifiez si l'utilisateur existe déjà
            $existingUser  = $this->userRepository->findOneBy(['login' => $login]);
            if ($existingUser ) {
                return $this->json(['message' => 'User  already exists'], Response::HTTP_CONFLICT);
            }

            // Créer un nouvel utilisateur
            $user = new User();
            $user->setLogin($login);
            $user->setPassword(password_hash($password, PASSWORD_BCRYPT)); // Hachage du mot de passe
            $user->setCreateAt(new \DateTimeImmutable());
            $user->setUpdateAt(new \DateTimeImmutable());
            $user->setBlocked(false); // Ou selon votre logique

            // Enregistrer l'utilisateur dans la base de données
            $this->entityManager->persist($user);
            $this->entityManager->flush();

            return $this->json(['message' => 'User  created successfully'], Response::HTTP_CREATED);
        }

        // Rendre le formulaire pour saisir le login et le mot de passe
        return $this->render('user/create.html.twig');
    }
}