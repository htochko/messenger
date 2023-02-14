<?php

namespace App\Message;

use App\Entity\ImagePost;

class AddLogoToImage
{
    public function __construct(private readonly ImagePost $imagePost)
    {
    }

    public function  getImagePost(): ImagePost
    {
        return $this->imagePost;
    }
}