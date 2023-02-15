<?php

namespace App\MessageHandler;

use App\Message\DeletePhotoFile;
use App\Services\Photo\PhotoFileManager;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
#[AsMessageHandler]
class DeletePhotoFileHandler
{
    public function __construct(private readonly PhotoFileManager $photoManager)
    {
    }
    public function __invoke(DeletePhotoFile $deletePhotoFile): void
    {
        $this->photoManager->deleteImage($deletePhotoFile->getFilename());
    }
}