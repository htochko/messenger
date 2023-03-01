<?php

namespace App\MessageHandler\Command;

use App\Message\Command\DeleteImagePost;
use App\Message\Command\DeletePhotoFile;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\MessageBusInterface;
#[AsMessageHandler]
class DeleteImagePostHandler
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly MessageBusInterface $eventBus,
    ){
    }

    public function __invoke(DeleteImagePost $deleteImagePost):void {
        $imagePost = $deleteImagePost->getImagePost();
        $filename = $imagePost->getFilename();
        $this->entityManager->remove($imagePost);
        $this->entityManager->flush();

        $this->eventBus->dispatch(new DeletePhotoFile($filename));
    }

    public static function getHandledMessages():iterable {
        yield DeleteImagePost::class => [
            'method' => '__invoke',
            'priority' => 10,
            'from_transport' => 'async',
        ];
    }
}