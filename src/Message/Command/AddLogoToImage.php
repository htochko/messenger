<?php

namespace App\Message\Command;

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