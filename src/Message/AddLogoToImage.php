<?php

namespace App\Message;

use App\Entity\ImagePost;

class AddLogoToImage
{
    public function __construct(private readonly int $imagePostId)
    {
    }

    public function  getImagePostId(): int
    {
        return $this->imagePostId;
    }
}