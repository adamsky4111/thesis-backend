<?php

namespace App\Serializer;

use App\Entity\User\User;
use App\Serializer\Factory\SerializerFactory;
use App\Service\User\Dto\UserDto;
use App\Service\User\Manager\AvatarCreator;
use Symfony\Component\Serializer\Normalizer\ContextAwareDenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Contracts\Translation\TranslatorInterface;

class UserSerializer implements ContextAwareNormalizerInterface, ContextAwareDenormalizerInterface
{
    protected Serializer $serializer;
    protected TranslatorInterface $translator;
    protected AvatarCreator $avatarCreator;

    public function __construct(
        TranslatorInterface $translator,
        AvatarCreator $avatarCreator,
    ) {
        $this->serializer = SerializerFactory::getObjectNormalizer();
        $this->translator = $translator;
        $this->avatarCreator = $avatarCreator;
    }

    public function supportsDenormalization($data, $type, $format = null, array $context = []): bool
    {
        return $type === UserDto::class;
    }

    public function supportsNormalization($data, $format = null, array $context = []): bool
    {
        return $data instanceof UserDto || $data instanceof User;
    }

    public function denormalize($data, $type = null, $format = null, array $context = []): object|array
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
        if ($object instanceof User) {
            $object = UserDto::createFromUser($object);
        }

        $serialized = $this->serializer->normalize($object, null, [
            'groups' => UserDto::GROUP_DEFAULT
        ]);

        $serialized['avatar'] = $this->avatarCreator->resolveAvatarPath($serialized['avatar']);

        return $serialized;
    }
}
