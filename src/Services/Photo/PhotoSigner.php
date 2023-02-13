<?php

namespace App\Services\Photo;

use Intervention\Image\Constraint;
use Intervention\Image\ImageManager;
use Symfony\Component\Finder\Finder;

class PhotoSigner
{
    public function __construct(private ImageManager $imageManager)
    {
    }

    public function addLogo(string $imageContents): string
    {
        $targetPhoto = $this->imageManager->make($imageContents);

        $logoFilename = $this->getRandomLogoFilename();
        $logoImage = $this->imageManager->make($logoFilename);

        $targetWidth = $targetPhoto->width() * .3;
        $targetHeight = $targetPhoto->height() * .4;

        $logoImage->resize($targetWidth, $targetHeight, function(Constraint $constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });

        $targetPhoto = $targetPhoto->insert(
            $logoImage,
            'bottom-right'
        );

        // for dramatic effect, make this *really* slow
        sleep(2);

        return (string) $targetPhoto->encode();
    }

    private function getRandomLogoFilename(): string
    {
        $finder = new Finder();
        $finder->in(__DIR__.'/../../../assets/logo')
            ->files();

        // array keys are the absolute file paths
        $logoFiles = iterator_to_array($finder->getIterator());

        return array_rand($logoFiles);
    }
}