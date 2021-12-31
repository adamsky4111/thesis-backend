<?php

namespace App\Controller\Api;

use App\Dto\ChannelDto;
use App\Entity\Stream\Channel;
use App\Filter\AccountChannelFilter;
use App\Security\Voter\User\ChannelVoter;
use App\Serializer\ChannelSerializer;
use App\Service\Channel\Subscriber\ChannelSubscriberInterface;
use App\Service\Stream\Manager\ChannelManagerInterface;
use App\Utils\RequestHelper;
use App\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/account/channel", name="api_account_channel_")
 */
class AccountChannelController extends AbstractController
{
    public function __construct(
        protected ChannelSerializer $serializer,
        protected ValidatorInterface $validator,
        protected ChannelManagerInterface $manager,
        protected ChannelSubscriberInterface $subscriber,
    ) {}


    /**
     * @Route("/", name="list", methods={"POST"})
     */
    public function listAction(Request $request): JsonResponse
    {
        /** @var AccountChannelFilter $filter */
        $filter = RequestHelper::denormalizeFromRequest($request, AccountChannelFilter::class);
        $result = $this->manager->getAccountChannels($filter);

        return $this->json(
            $result
        );
    }

    /**
     * @Route("/create", name="create", methods={"POST"})
     */
    public function createAction(Request $request): JsonResponse
    {
//        $this->denyAccessUnlessGranted(ChannelVoter::CREATE);
        try {
            /** @var ChannelDto $channel */
            $channel = $this->serializer->denormalize($request->getContent());
        } catch (\Exception) {
            return $this->json(['errors' => 'wrong json format'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if ($this->validator->validate($channel, [ChannelDto::GROUP_CREATE])) {
            return $this->json(['errors' => $this->validator->getErrors()]);
        }

        $channel = $this->manager->create($channel);

        return $this->json(['channel' => $channel]);
    }

    /**
     * @Route("/edit/{id}", name="edit", methods={"PUT"})
     */
    public function editAction(Request $request, $id): JsonResponse
    {
        $channel = $this->manager->getOr404($id);

        $this->denyAccessUnlessGranted(ChannelVoter::UPDATE, $channel);
        try {
            /** @var ChannelDto $channelDto */
            $channelDto = $this->serializer->denormalize($request->getContent());
        } catch (\Exception $e) {
            return $this->json(['errors' => 'wrong json format', 'message' => $e->getMessage()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if ($this->validator->validate($channelDto, [ChannelDto::GROUP_UPDATE])) {
            return $this->json(['errors' => $this->validator->getErrors()]);
        }

        $channel = $this->manager->update($channelDto, $channel);

        return $this->json(['channel' => $channel]);
    }

    /**
     * @Route("/show/{id}", name="show", methods={"GET"})
     */
    public function showAction(Request $request, $id): JsonResponse
    {
        $channel = $this->manager->getOr404($id);

        $this->denyAccessUnlessGranted(ChannelVoter::VIEW, $channel);

        return $this->json(['channel' => $this->serializer->normalize(
            $channel,
            null,
            ['groups' => ChannelDto::GROUP_DEFAULT]
        )]);
    }

    /**
     * @Route("/delete/{id}", name="delete", methods={"DELETE"})
     */
    public function deleteAction(Request $request, $id): JsonResponse
    {
        $channel = $this->manager->getOr404($id);

        $this->denyAccessUnlessGranted(ChannelVoter::DELETE, $channel);

        $this->manager->delete($channel);

        return $this->json(['channel' => $channel]);
    }

    /**
     * @Route("/subscribed", name="subscribed", methods={"GET"})
     */
    public function favoriteAction(): JsonResponse
    {
        $channels = $this->subscriber->getSubscribed();
        return $this->json(['items' => $channels]);
    }

    /**
     * @Route("/subscribe/{id}", name="subscribe", methods={"PUT"})
     */
    public function subscribeAction(Channel $channel): JsonResponse
    {
        try {
            $this->subscriber->subscribe($channel);
        } catch (\Exception $exception) {
            return $this->json(['errors' => [$exception->getMessage()]]);
        }

        return $this->json(['channel' => $channel]);
    }

    /**
     * @Route("/unsubscribe/{id}", name="unsubscribe", methods={"PUT"})
     */
    public function unsubscribeAction(Channel $channel): JsonResponse
    {
        try {
            $this->subscriber->unsubscribe($channel);
        } catch (\Exception $exception) {
            return $this->json(['errors' => [$exception->getMessage()]]);
        }

        return $this->json(['channel' => $channel]);
    }
}
