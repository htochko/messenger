<?php

namespace App\Message\Event;
class ImagePostDeletedEvent
{
    public function __construct(readonly private string $filename)
    {
    }

    public function getFilename(): string
    {
        return $this->filename;
    }
}