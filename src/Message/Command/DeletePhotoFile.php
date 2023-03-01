<?php

namespace App\Message\Command;

class DeletePhotoFile
{
    public function __construct(private readonly string $filename)
    {
    }
    public function getFilename(): string
    {
        return $this->filename;
    }
}