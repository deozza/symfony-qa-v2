<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\UserService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class UserController extends AbstractController
{
    #[Route('/user', name: 'app_create_user', methods: ['POST'])]
    public function createUser(Request $request, EntityManagerInterface $em, UserService $userService): JsonResponse {
        $payload = json_decode($request->getContent(), true);

        try {
            $user = $userService->createUser($payload);
            return $this->json($user, 201);
        } catch(\Exception $e) {
            return $this->json(['error' => $e->getMessage(), 422]);
        }
    }
}
