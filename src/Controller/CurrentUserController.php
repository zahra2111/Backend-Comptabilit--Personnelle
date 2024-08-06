<?php
// src/Controller/CurrentUserController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class CurrentUserController extends AbstractController
{
    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    #[Route('/api/current_user', name: 'api_current_user', methods: ['GET'])]
    public function __invoke(): JsonResponse
    {
        $user = $this->security->getUser();

        if (!$user) {
            return new JsonResponse(['message' => 'User not authenticated'], JsonResponse::HTTP_UNAUTHORIZED);
        }

        // Serialize the user to a format that can be returned as JSON
        // Assuming that User entity has a method to get array representation.
        return new JsonResponse($user->toArray());
    }
}
