<?php

namespace App\MessageHandler;

use App\Message\DeleteImagePost;
use App\Services\Photo\PhotoFileManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class DeleteImagePostHandler
{
    public function __construct(
        private readonly PhotoFileManager $photoFileManager,
        private readonly EntityManagerInterface $entityManager
    ){
    }

    public function __invoke(DeleteImagePost $deleteImagePost):void {
        $imagePost = $deleteImagePost->getImagePost();
        $this->photoFileManager->deleteImage($imagePost->getFilename());
        $this->entityManager->remove($imagePost);
        $this->entityManager->flush();
    }
}