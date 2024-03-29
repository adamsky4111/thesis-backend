<?php

namespace App\Serializer;

use App\Dto\ChannelDto;
use App\Entity\Stream\Channel;
use App\Serializer\Factory\SerializerFactory;
use App\Service\User\Context\AccountContextInterface;
use App\Service\User\Manager\AvatarCreatorInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\ContextAwareDenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Contracts\Translation\TranslatorInterface;

class ChannelSerializer implements ContextAwareNormalizerInterface, ContextAwareDenormalizerInterface
{
    protected Serializer $serializer;
    protected TranslatorInterface $translator;
    protected AvatarCreatorInterface $avatarCreator;
    protected AccountContextInterface $context;

    public function __construct(
        TranslatorInterface $translator,
        AvatarCreatorInterface $avatarCreator,
        AccountContextInterface $context
    ) {
        $this->serializer = SerializerFactory::getObjectNormalizer();
        $this->translator = $translator;
        $this->avatarCreator = $avatarCreator;
        $this->context = $context;
    }

    public function supportsDenormalization($data, $type, $format = null, array $context = []): bool
    {
        return $type === ChannelDto::class;
    }

    public function supportsNormalization($data, $format = null, array $context = []): bool
    {
        return $data instanceof ChannelDto || $data instanceof Channel;
    }

    public function denormalize($data, $type = null, $format = null, array $context = ['groups' => ChannelDto::GROUP_CREATE]): object|array
    {
        return $this->serializer->deserialize(
            $data,
            ChannelDto::class,
            'json',
            $context
        );
    }

    public function normalize($object, $format = null, array $context = ['groups' => ChannelDto::GROUP_LIST, ])
    {
        $subscribed = false;
        $account = $this->context->getAccount();

        if ($object instanceof Channel) {
            if ($account) {
                $subscribed = $account->isChannelSubscribed($object);
            }
            $object = ChannelDto::createFromObject($object);
        }

        $context = [
            'groups' => ChannelDto::GROUP_LIST,
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object) {
                return $object->getId();
            },
            AbstractObjectNormalizer::ENABLE_MAX_DEPTH => true,
        ];


        $data = $this->serializer->normalize($object, null, [
            $context
        ]);
        $data['subscribed'] = $subscribed;

        return $data;
    }
}
