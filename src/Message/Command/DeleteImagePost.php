<?php

namespace App\Message\Command;

use App\Entity\ImagePost;

class DeleteImagePost {
    public function __construct(private readonly ImagePost $imagePost)
    {
    }

    public function  getImagePost(): ImagePost
    {
        return $this->imagePost;
    }
}