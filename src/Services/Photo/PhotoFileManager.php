<?php

namespace App\Services\Photo;

use App\Entity\ImagePost;
use League\Flysystem\FilesystemException;
use League\Flysystem\FilesystemOperator;
use League\Flysystem\Visibility;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class PhotoFileManager
{
    public function __construct(
        private FilesystemOperator $photoFilesystem,
        private string $publicAssetBaseUrl)
    {
    }

    /**
     * @throws \Exception
     */
    public function uploadImage(File $file)
    {
        if ($file instanceof UploadedFile) {
            $originalFilename = $file->getClientOriginalName();
        } else {
            $originalFilename = $file->getFilename();
        }

        $newFilename = pathinfo($originalFilename, PATHINFO_FILENAME).'-'.uniqid().'.'.$file->guessExtension();
        $stream = fopen($file->getPathname(), 'r');
        try {
            $this->photoFilesystem->writeStream(
                $newFilename,
                $stream,
                [
                    'visibility' => Visibility::PUBLIC
                ]
            );
        } catch (FilesystemException $exception) {
            throw new \Exception(sprintf('Could not write uploaded file "%s"', $newFilename));
        }

        if (is_resource($stream)) {
            fclose($stream);
        }

        return $newFilename;
    }

    public function deleteImage(string $filename): void
    {
        // make it a bit slow
        sleep(3);

        $this->photoFilesystem->delete($filename);
    }

    public function getPublicPath(ImagePost $imagePost): string
    {
        return $this->publicAssetBaseUrl.'/'.$imagePost->getFilename();
    }

    /**
     * @throws FilesystemException
     */
    public function read(string $filename): string
    {
        return $this->photoFilesystem->read($filename);
    }

    /**
     * @throws FilesystemException
     */
    public function update(string $filename, string $updatedContents): void
    {
        $this->photoFilesystem->write($filename, $updatedContents);
    }
}
