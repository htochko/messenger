<?php

namespace App\MessageHandler;

use App\Message\DeleteImagePost;
use App\Message\DeletePhotoFile;
use App\Services\Photo\PhotoFileManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\MessageBusInterface;
#[AsMessageHandler]
class DeleteImagePostHandler
{
    public function __construct(
        private readonly PhotoFileManager $photoFileManager,
        private readonly EntityManagerInterface $entityManager,
        private readonly MessageBusInterface $messageBus,
    ){
    }

    public function __invoke(DeleteImagePost $deleteImagePost):void {
        $imagePost = $deleteImagePost->getImagePost();
        $filename = $imagePost->getFilename();
        $this->entityManager->remove($imagePost);
        $this->entityManager->flush();

        $this->messageBus->dispatch(new DeletePhotoFile($filename));
    }
}