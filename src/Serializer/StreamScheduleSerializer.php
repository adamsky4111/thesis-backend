<?php

namespace App\Serializer;

use App\Dto\StreamScheduleDto;
use App\Entity\Stream\StreamSchedule;
use App\Serializer\Factory\SerializerFactory;
use App\Service\Stream\Provider\StreamUrlProviderInterface;
use App\Service\User\Manager\AvatarCreatorInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\ContextAwareDenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Contracts\Translation\TranslatorInterface;

class StreamScheduleSerializer implements ContextAwareNormalizerInterface, ContextAwareDenormalizerInterface
{
    protected Serializer $serializer;
    protected TranslatorInterface $translator;
    protected AvatarCreatorInterface $avatarCreator;
    protected StreamUrlProviderInterface $provider;

    public function __construct(
        TranslatorInterface $translator,
        AvatarCreatorInterface $avatarCreator,
        StreamUrlProviderInterface $provider,
    ) {
        $this->serializer = SerializerFactory::getObjectNormalizer();
        $this->translator = $translator;
        $this->avatarCreator = $avatarCreator;
        $this->provider = $provider;
    }

    public function supportsDenormalization($data, $type, $format = null, array $context = []): bool
    {
        return $type === StreamScheduleDto::class;
    }

    public function supportsNormalization($data, $format = null, array $context = []): bool
    {
        return $data instanceof StreamScheduleDto || $data instanceof StreamSchedule;
    }

    public function denormalize($data, $type = null, $format = null, array $context = ['groups' => StreamScheduleDto::GROUP_LIST]): object|array
    {
        return $this->serializer->deserialize(
            $data,
            StreamScheduleDto::class,
            'json',
            $context
        );
    }

    public function normalize($object, $format = null, array $context = ['groups' => StreamScheduleDto::GROUP_LIST, ])
    {
        if ($object instanceof StreamSchedule) {
            $object = StreamScheduleDto::createFromObject($object);
        }

        $settings = [
            $context,
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object) {
                return $object->getId();
            },
            AbstractObjectNormalizer::ENABLE_MAX_DEPTH => true,
        ];

        $data = $this->serializer->normalize($object, null, [
            $settings
        ]);

        return $data;
    }
}
