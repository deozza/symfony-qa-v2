<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController {

    #[Route(path: '/', name: 'home', methods: ['GET'])]
    public function homePage(UserRepository $userRepository): Response {

        $users = $userRepository->findOneBy([
            'email' => 'email1@gmail.com'
        ]);

        dump($users);die;


        return $this->render('home.html.twig', [
            'title' => 'Pouet',
            'fruits' => [
                'banane',
                'orange',
                'pomme',
                'poire'
            ],
            'number' => 23
        ]);
    }
}
