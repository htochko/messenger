<?php

namespace App\MessageHandler;

use App\Message\AddLogoToImage;
use App\Services\Photo\PhotoFileManager;
use App\Services\Photo\PhotoSigner;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class AddLogoToImageHandler
{
    public function __construct(
        private readonly PhotoSigner $photoSigner,
        private readonly EntityManagerInterface $entityManager,
        private readonly PhotoFileManager $photoManager
    ) {
    }
    public function __invoke(AddLogoToImage $addLogoToImage): void
    {
        $imagePost = $addLogoToImage->getImagePost();
        $updatedContents = $this->photoSigner->addLogo(
            $this->photoManager->read($imagePost->getFilename())
        );
        $this->photoManager->update($imagePost->getFilename(), $updatedContents);
        $imagePost->markAsLogoAdded();
        $this->entityManager->flush();
    }
}