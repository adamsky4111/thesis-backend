<?php

namespace App\Serializer;

use App\Entity\User\User;
use App\Serializer\Factory\SerializerFactory;
use App\Service\User\Dto\UserDto;
use Symfony\Component\Serializer\Normalizer\ContextAwareDenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Contracts\Translation\TranslatorInterface;

class UserSerializer implements ContextAwareNormalizerInterface, ContextAwareDenormalizerInterface
{
    protected Serializer $serializer;
    protected TranslatorInterface $translator;

    public function __construct(
        TranslatorInterface $translator,
    ) {
        $this->serializer = SerializerFactory::getObjectNormalizer();
        $this->translator = $translator;
    }

    public function supportsDenormalization($data, $type, $format = null, array $context = []): bool
    {
        return $type === UserDto::class;
    }

    public function supportsNormalization($data, $format = null, array $context = []): bool
    {
        return $data instanceof User;
    }

    public function denormalize($data, $type, $format = null, array $context = []): object|array
    {
        return $this->serializer->deserialize(
            $data,
            UserDto::class,
            'json',
            ['groups' => UserDto::GROUP_CREATE]
        );
    }

    public function normalize($object, $format = null, array $context = [])
    {
        return $this->serializer->normalize(UserDto::createFromUser($object), null, [
            'groups' => UserDto::GROUP_DEFAULT
        ]);
    }
}
