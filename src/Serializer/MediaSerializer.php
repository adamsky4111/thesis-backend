<?php

namespace App\Serializer;

use App\Dto\MediaDto;
use App\Entity\User\Media;
use App\Serializer\Factory\SerializerFactory;
use App\Service\Media\Manager\MediaManagerInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\ContextAwareDenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Serializer;

class MediaSerializer implements ContextAwareNormalizerInterface, ContextAwareDenormalizerInterface
{
    protected Serializer $serializer;

    public function __construct(
        protected MediaManagerInterface $manager,
    ) {
        $this->serializer = SerializerFactory::getObjectNormalizer();
    }

    public function supportsDenormalization($data, $type, $format = null, array $context = []): bool
    {
        return $type === MediaDto::class;
    }

    public function supportsNormalization($data, $format = null, array $context = []): bool
    {
        return $data instanceof MediaDto || $data instanceof Media;
    }

    public function denormalize($data, $type = null, $format = null, array $context = ['groups' => MediaDto::GROUP_CREATE]): object|array
    {
        return $this->serializer->deserialize(
            $data,
            MediaDto::class,
            'json',
            $context
        );
    }

    public function normalize($object, $format = null, array $context = ['groups' => MediaDto::GROUP_LIST, ])
    {
        if ($object instanceof Media) {
            $path = $this->manager->resolvePath($object);
            $object = MediaDto::createFromObject($object, $path);
        }
        $context = [
            'groups' => MediaDto::GROUP_LIST,
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object) {
                return $object->getId();
            },
            AbstractObjectNormalizer::ENABLE_MAX_DEPTH => true,
        ];
        return $this->serializer->normalize($object, null, [
            $context
        ]);
    }
}
