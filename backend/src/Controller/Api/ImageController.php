<?php
// src/Controller/Api/PhotoController.php

namespace App\Controller\Api;

use App\Entity\Image;
use App\Entity\Photo;
use App\Entity\Likes;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ImageController extends AbstractController
{
    /**
     * Ajoute un like à une photo.
     *
     * @param Photo $photo L'entité photo récupérée automatiquement via le paramConverter (paramètre {id})
     */
    #[Route('/api/photos/{id}/like', name: 'api_photo_like', methods: ['POST'])]
    public function addLike(Image $image, EntityManagerInterface $em): JsonResponse
    {
        // Récupérer l'utilisateur connecté
        $user = $this->getUser();
        if (!$user) {
            return new JsonResponse(['error' => 'Non autorisé'], Response::HTTP_UNAUTHORIZED);
        }

        // Vérifier si le like existe déjà (pour éviter les doublons)
        $existingLike = $em->getRepository(Likes::class)->findOneBy([
            'user' => $user,
            'image' => $image,
        ]);
        if ($existingLike) {
            return new JsonResponse(['error' => 'Vous avez déjà liké cette photo'], Response::HTTP_BAD_REQUEST);
        }

        $like = new Likes();
        $like->setUser($user);
        $like->setImage($image);

        $em->persist($like);
        $em->flush();

        return new JsonResponse(['message' => 'Like ajouté'], Response::HTTP_CREATED);
    }

    /**
     * Ajoute une nouvelle photo.
     *
     * On attend un champ "title" et un fichier "image" dans la requête.
     */
    #[Route('/api/image', name: 'api_image_add', methods: ['POST'])]
    public function addPhoto(Request $request, EntityManagerInterface $em): JsonResponse
    {
        // Récupérer les données du formulaire
        $file = $request->files->get('image');

        if (!$file) {
            return new JsonResponse(['error' => 'Données incomplètes (title et image requis)'], Response::HTTP_BAD_REQUEST);
        }

        // Lire le contenu du fichier (pour le stocker en BLOB ou en base64)
        $imageContent = file_get_contents($file->getPathname());

        $image = new Image();
        $image->setImageData($imageContent);
        $image->setUser($this->getUser());


        $em->persist($image);
        $em->flush();

        return new JsonResponse([
            'message' => 'Image ajoutée',
            'id' => $image->getId(),
        ], Response::HTTP_CREATED);
    }

    /**
     * Supprime une photo.
     *
     * Cette route supprime la photo dont l'id est fourni dans l'URL.
     */
    #[Route('/api/photos/{id}', name: 'api_photo_delete', methods: ['DELETE'])]
    public function deletePhoto(Image $image, EntityManagerInterface $em): JsonResponse
    {
        // Vous pouvez ajouter ici une vérification d'autorisation
        // Par exemple, vérifier si l'utilisateur connecté est le propriétaire de la photo

        $em->remove($image);
        $em->flush();

        return new JsonResponse(['message' => 'Image supprimée'], Response::HTTP_OK);
    }

    #[Route('/api/image', name: 'api_photo_get', methods: ['GET'])]
    public function getPhotos(EntityManagerInterface $em): JsonResponse
    {
        $images = $em->getRepository(Image::class)->findBy(['user' => $this->getUser()]);

        $data = [];
        foreach ($images as $image) {
            $data[] = [
                'id' => $image->getId(),
                'user' => $image->getUser()->getUsername(),
                'imageData' => base64_encode(stream_get_contents($image->getImageData())),
            ];
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }

    #[Route('/api/image/all', name: 'api_all_photo_get', methods: ['GET'])]
    public function getAllPhotos(EntityManagerInterface $em): JsonResponse
    {
        $images = $em->getRepository(Image::class)->findBy(['user' => !$this->getUser()]);

        $data = [];
        foreach ($images as $image) {
            $data[] = [
                'id' => $image->getId(),
                'user' => $image->getUser()->getUsername(),
                'imageData' => base64_encode(stream_get_contents($image->getImageData())),
            ];
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }
}
