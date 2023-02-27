<?php

namespace App\MessageHandler\Event;

use App\Message\Event\ImagePostDeletedEvent;
use App\Services\Photo\PhotoFileManager;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class RemoveFileWhenImagePostDeleted
{
    public function __construct(readonly private PhotoFileManager $photoFileManager)
    {
    }
    public function __invoke(ImagePostDeletedEvent $event): void
    {
        $this->photoFileManager->deleteImage($event->getFilename());
    }
}