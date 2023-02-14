<?php

namespace App\Serializer\Normalizer;

use App\Services\Photo\PhotoFileManager;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\Normalizer\CacheableSupportsMethodInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use App\Entity\ImagePost;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
class ImagePostNormalizer implements NormalizerInterface, CacheableSupportsMethodInterface
{
    use NormalizerAwareTrait;

    const ALREADY_CALLED = 'IMAGE_POST_NORMALIZER_ALREADY_CALLED';

    public function __construct(
        private PhotoFileManager $uploaderManager,
        private UrlGeneratorInterface $router)
    {

    }

    public function normalize($object, string $format = null, array $context = []): array
    {
        $context[self::ALREADY_CALLED] = true;
        $data = $this->normalizer->normalize($object, $format, $context);

        $data['@id'] = $this->router->generate('get_image_post_item', [
            'id' => $object->getId(),
        ]);
        $data['url'] = $this->uploaderManager->getPublicPath($object);

        return $data;
    }

    public function supportsNormalization($data, string $format = null, array $context = []): bool
    {
        if (isset($context[self::ALREADY_CALLED])) {
            return false;
        }
        return $data instanceof ImagePost;
    }

    public function hasCacheableSupportsMethod(): bool
    {
        return true;
    }
}
