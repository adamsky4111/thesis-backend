<?php

namespace App\Serializer;

use App\Dto\ChannelDto;
use App\Dto\MessageDto;
use App\Entity\Stream\Channel;
use App\Entity\Stream\Message;
use App\Serializer\Factory\SerializerFactory;
use App\Service\User\Manager\AvatarCreatorInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\ContextAwareDenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Contracts\Translation\TranslatorInterface;

class MessageSerializer implements ContextAwareNormalizerInterface, ContextAwareDenormalizerInterface
{
    protected Serializer $serializer;
    protected TranslatorInterface $translator;
    protected AvatarCreatorInterface $avatarCreator;

    public function __construct(
        TranslatorInterface $translator,
        AvatarCreatorInterface $avatarCreator,
    ) {
        $this->serializer = SerializerFactory::getObjectNormalizer();
        $this->translator = $translator;
        $this->avatarCreator = $avatarCreator;
    }

    public function supportsDenormalization($data, $type, $format = null, array $context = []): bool
    {
        return $type === MessageDto::class;
    }

    public function supportsNormalization($data, $format = null, array $context = []): bool
    {
        return $data instanceof MessageDto || $data instanceof Message;
    }

    public function denormalize($data, $type = null, $format = null, array $context = ['groups' => MessageDto::GROUP_CREATE]): object|array
    {
        return $this->serializer->deserialize(
            $data,
            MessageDto::class,
            'json',
            $context
        );
    }

    public function normalize($object, $format = null, array $context = ['groups' => MessageDto::GROUP_LIST, ])
    {
        if ($object instanceof Message) {
            $object = MessageDto::createFromObject($object);
        }

        $context = [
            'groups' => MessageDto::GROUP_LIST,
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object) {
                return $object->getId();
            },
            AbstractObjectNormalizer::ENABLE_MAX_DEPTH => true,
        ];

        $serialized = $this->serializer->normalize($object, null, [
            $context
        ]);

        $serialized['avatar'] = $this->avatarCreator->resolveAvatarPath($object->getAvatar());

        return $serialized;
    }
}
