<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiController extends AbstractController
{
    #[Route('/api', name: 'api_welcome', methods: ['GET'])]
    public function welcome(Request $request): Response
    {
        return new Response('Bienvnue sur l\'API Symfony', Response::HTTP_OK);
    }

    #[Route('/api/users', name: 'api_users', methods: ['GET'])]
    public function users(Request $request): Response
    {
        return new Response('Liste des utilisateurs', Response::HTTP_OK);
    }

    #[Route('/api/login', name: 'api_login', methods: ['POST'])]
    public function login(Request $request): Response
    {
        return new Response('Login', Response::HTTP_OK);
    }
}
