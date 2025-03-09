<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiController extends AbstractController
{
    /**
     * @Route("/api", name="api_welcome", methods={"GET"})
     */
    public function welcome(Request $request): Response
    {
        return new Response('Bienvnue sur l\'API Symfony', Response::HTTP_OK);
    }

    /**
     * @Route("/api/register", name="api_register", methods={"POST"})
     */
    public function register(Request $request): Response
    {
        return new Response('Utilisateur enregistré', Response::HTTP_CREATED);
    }

    /**
     * @Route("/api/login", name="api_login", methods={"POST"})
     */
    public function login(Request $request): Response
    {
        return new Response('Connexion réussie', Response::HTTP_OK);
    }

    /**
     * @Route("/api/images", name="api_images", methods={"GET"})
     */
    public function getImages(): Response
    {
        // Récupérer et renvoyer la liste des images disponibles (généralement sous format JSON)
        return new Response('Liste des images', Response::HTTP_OK);
    }

    /**
     * @Route("/api/images/{id}/like", name="api_image_like", methods={"POST"})
     */
    public function likeImage($id): Response
    {
        // Enregistrer le like pour l'image d'identifiant $id
        return new Response("Image $id likée", Response::HTTP_OK);
    }

    /**
     * @Route("/api/images/{id}/dislike", name="api_image_dislike", methods={"POST"})
     */
    public function dislikeImage($id): Response
    {
        // Enregistrer le dislike pour l'image d'identifiant $id
        return new Response("Image $id dislikée", Response::HTTP_OK);
    }
}
