<?php

namespace App\Serializer;

use App\Dto\StreamDto;
use App\Entity\Stream\Channel;
use App\Entity\Stream\Stream;
use App\Serializer\Factory\SerializerFactory;
use App\Service\Stream\Provider\StreamUrlProviderInterface;
use App\Service\User\Context\AccountContextInterface;
use App\Service\User\Manager\AvatarCreatorInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\ContextAwareDenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Contracts\Translation\TranslatorInterface;

class StreamSerializer implements ContextAwareNormalizerInterface, ContextAwareDenormalizerInterface
{
    protected Serializer $serializer;
    protected TranslatorInterface $translator;
    protected AvatarCreatorInterface $avatarCreator;
    protected StreamUrlProviderInterface $provider;
    protected AccountContextInterface $context;

    public function __construct(
        TranslatorInterface $translator,
        AvatarCreatorInterface $avatarCreator,
        StreamUrlProviderInterface $provider,
        AccountContextInterface $context,
    ) {
        $this->serializer = SerializerFactory::getObjectNormalizer();
        $this->translator = $translator;
        $this->avatarCreator = $avatarCreator;
        $this->provider = $provider;
        $this->context = $context;
    }

    public function supportsDenormalization($data, $type, $format = null, array $context = []): bool
    {
        return $type === StreamDto::class;
    }

    public function supportsNormalization($data, $format = null, array $context = []): bool
    {
        return $data instanceof StreamDto || $data instanceof Stream;
    }

    public function denormalize($data, $type = null, $format = null, array $context = ['groups' => StreamDto::GROUP_CREATE]): object|array
    {
        return $this->serializer->deserialize(
            $data,
            StreamDto::class,
            'json',
            $context
        );
    }

    public function normalize($object, $format = null, array $context = ['groups' => StreamDto::GROUP_LIST, ])
    {
        $subscribed = false;
        $account = $this->context->getAccount();

        if ($object instanceof Stream) {
            if (($channel = $object->getChannel()) instanceof Channel) {
                if ($account) {
                    $subscribed = $account->isChannelSubscribed($channel);
                }
            }
            $object = StreamDto::createFromObject($object);
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

        $data['url'] = $this->provider->loadStreamUrl($object);
        $data['channel']['subscribed'] = $subscribed;

        return $data;
    }
}
