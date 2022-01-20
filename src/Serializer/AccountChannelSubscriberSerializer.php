<?php

namespace App\Serializer;

use App\Dto\AccountChannelSubscribeDto;
use App\Dto\ChannelDto;
use App\Entity\Stream\Channel;
use App\Entity\User\AccountChannelSubscribe;
use App\Serializer\Factory\SerializerFactory;
use App\Service\User\Context\AccountContextInterface;
use App\Service\User\Manager\AvatarCreatorInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\ContextAwareDenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Contracts\Translation\TranslatorInterface;

class AccountChannelSubscriberSerializer implements ContextAwareNormalizerInterface, ContextAwareDenormalizerInterface
{
    protected Serializer $serializer;
    protected AccountContextInterface $context;

    public function __construct(
        AccountContextInterface $context
    ) {
        $this->serializer = SerializerFactory::getObjectNormalizer();
        $this->context = $context;
    }

    public function supportsDenormalization($data, $type, $format = null, array $context = []): bool
    {
        return $type === AccountChannelSubscribeDto::class;
    }

    public function supportsNormalization($data, $format = null, array $context = []): bool
    {
        return $data instanceof AccountChannelSubscribeDto || $data instanceof AccountChannelSubscribe;
    }

    public function denormalize($data, $type = null, $format = null, array $context = ['groups' => AccountChannelSubscribeDto::GROUP_LIST]): object|array
    {
        return $this->serializer->deserialize(
            $data,
            AccountChannelSubscribeDto::class,
            'json',
            $context
        );
    }

    public function normalize($object, $format = null, array $context = ['groups' => AccountChannelSubscribeDto::GROUP_LIST, ])
    {
        $subscribed = false;
        $account = $this->context->getAccount();

        if ($object instanceof AccountChannelSubscribe) {
            if ($account) {
                $subscribed = $account->isChannelSubscribed($object->getChannel());
            }
            $object = AccountChannelSubscribeDto::createFromObject($object);
        }

        $context = [
            'groups' => AccountChannelSubscribeDto::GROUP_LIST,
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object) {
                return $object->getId();
            },
            AbstractObjectNormalizer::ENABLE_MAX_DEPTH => true,
        ];


        $data = $this->serializer->normalize($object, null, [
            $context
        ]);
        $data['channel']['subscribed'] = $subscribed;

        return $data;
    }
}
