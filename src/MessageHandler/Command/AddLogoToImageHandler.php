<?php

namespace App\MessageHandler\Command;

use App\Message\Command\AddLogoToImage;
use App\Repository\ImagePostRepository;
use App\Services\Photo\PhotoFileManager;
use App\Services\Photo\PhotoSigner;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class AddLogoToImageHandler implements LoggerAwareInterface
{
    use LoggerAwareTrait;
    public function __construct(
        private readonly PhotoSigner            $photoSigner,
        private readonly EntityManagerInterface $entityManager,
        private readonly PhotoFileManager       $photoManager,
        private readonly ImagePostRepository    $imagePostRepository,
    ) {
    }
    public function __invoke(AddLogoToImage $addLogoToImage): void
    {
        $imagePostId = $addLogoToImage->getImagePostId();
        $imagePost = $this->imagePostRepository->find($imagePostId);

        if (!$imagePost) {
            // could throw an exception... it would be retried
            // or return and this message will be discarded
            if ($this->logger) {
                $this->logger->alert(sprintf('Image post %d was missing!', $imagePostId));
            }
            return;
        }

        $updatedContents = $this->photoSigner->addLogo(
            $this->photoManager->read($imagePost->getFilename())
        );
        $this->photoManager->update($imagePost->getFilename(), $updatedContents);
        $imagePost->markAsLogoAdded();
        $this->entityManager->flush();
    }
}