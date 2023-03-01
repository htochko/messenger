<?php

namespace App\MessageHandler\Query;

use App\Message\Query\GetTotalImageCount;
use App\Repository\ImagePostRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class GetTotalImageCountHandler
{
    public function __construct(
        private readonly ImagePostRepository $imagePostRepository
    ){
    }

    public function __invoke(
        GetTotalImageCount $getTotalImageCount)
    : int {
        return $this->imagePostRepository->count([]);
    }
}