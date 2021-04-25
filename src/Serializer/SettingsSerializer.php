<?php

namespace App\Serializer;

use App\Dto\SettingsDto;
use App\Entity\User\Settings;
use App\Serializer\Factory\SerializerFactory;
use App\Service\User\Manager\AvatarCreatorInterface;
use Symfony\Component\Serializer\Normalizer\ContextAwareDenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Contracts\Translation\TranslatorInterface;

class SettingsSerializer implements ContextAwareNormalizerInterface, ContextAwareDenormalizerInterface
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
        return $type === SettingsDto::class;
    }

    public function supportsNormalization($data, $format = null, array $context = []): bool
    {
        return $data instanceof SettingsDto || $data instanceof Settings;
    }

    public function denormalize($data, $type = null, $format = null, array $context = []): object|array
    {
        return $this->serializer->deserialize(
            $data,
            SettingsDto::class,
            'json',
            ['groups' => SettingsDto::GROUP_CREATE]
        );
    }

    public function normalize($object, $format = null, array $context = [])
    {
        if ($object instanceof Settings) {
            $object = SettingsDto::createFromObject($object);
        }

        return $this->serializer->normalize($object, null, [
            'groups' => SettingsDto::GROUP_DEFAULT
        ]);
    }
}
