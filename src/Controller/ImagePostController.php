<?php

namespace App\Controller;

use App\Entity\ImagePost;
use App\Services\Photo\PhotoSigner;
use App\Repository\ImagePostRepository;
use App\Services\Photo\PhotoFileManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ImagePostController extends AbstractController
{
    #[Route("/api/images", methods: ["GET"])]
    public function list(ImagePostRepository $repository): Response
    {
        $posts = $repository->findBy([], ['createdAt' => 'DESC']);

        return $this->toJson([
            'items' => $posts
        ]);
    }

    /**
     * @throws \Exception
     */
    #[Route("/api/images", methods: ["POST"])]
    public function create(
        Request $request,
        ValidatorInterface $validator,
        PhotoFileManager $photoManager,
        EntityManagerInterface $entityManager,
        PhotoSigner $photoSigner
    )
    {
        /** @var UploadedFile $imageFile */
        $imageFile = $request->files->get('file');

        $errors = $validator->validate($imageFile, [
            new Image(),
            new NotBlank()
        ]);

        if (count($errors) > 0) {
            return $this->toJson($errors, 400);
        }

        $newFilename = $photoManager->uploadImage($imageFile);
        $imagePost = new ImagePost();
        $imagePost->setFilename($newFilename);
        $imagePost->setOriginalFilename($imageFile->getClientOriginalName());

        $entityManager->persist($imagePost);
        $entityManager->flush();

        /*
         * Start adding a logo
         */
        $updatedContents = $photoSigner->addLogo(
            $photoManager->read($imagePost->getFilename())
        );
        $photoManager->update($imagePost->getFilename(), $updatedContents);
        $imagePost->markAsLogoAdded();
        $entityManager->flush();

        /*
         * end adding logo
         */

        return $this->toJson($imagePost, 201);
    }

    #[Route('/api/images/{id}', methods: ['DELETE'])]
    public function delete(ImagePost $imagePost, EntityManagerInterface $entityManager, PhotoFileManager $photoManager)
    {
        $photoManager->deleteImage($imagePost->getFilename());

        $entityManager->remove($imagePost);
        $entityManager->flush();

        return new Response(null, 204);
    }

    #[Route('/api/images/{id}', name: 'get_image_post_item', methods: ['GET'])]
    public function getItem(ImagePost $imagePost): Response
    {
        return $this->toJson($imagePost);
    }

    private function toJson($data, int $status = 200, array $headers = [], array $context = []): JsonResponse
    {
        // add the image:output group by default
        if (!isset($context['groups'])) {
            $context['groups'] = ['image:output'];
        }

        return $this->json($data, $status, $headers, $context);
    }
}
