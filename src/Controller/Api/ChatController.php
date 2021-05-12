<?php

namespace App\Controller\Api;

use App\Dto\MessageDto;
use App\Serializer\MessageSerializer;
use App\Service\Chat\Manager\ChatManagerInterface;
use App\Service\Stream\Manager\StreamManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/chat", name="api_chat_")
 */
class ChatController extends AbstractController
{
    public function __construct(
        private ChatManagerInterface $manager,
        private MessageSerializer $serializer,
        private StreamManagerInterface $streamManager,
    ) {}

    /**
     * @Route("/{streamId}/add-message", name="add_message", methods={"POST"})
     */
    public function addMessageAction(Request $request, $streamId): JsonResponse
    {
        try {
            /** @var MessageDto $message */
            $message = $this->serializer->denormalize($request->getContent());
        } catch (\Exception $exception) {
            return $this->json(['errors' => 'wrong json format'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $stream = $this->streamManager->getOr404($streamId);

        $chat = $stream->getChat();

        $message = $this->manager->addMessage($message, $chat);

        return $this->json(['message' => $message]);
    }
    /**
     *
     * @Route("/{streamId}", name="list", methods={"GET"})
     */
    public function listAction($streamId): JsonResponse
    {
        $stream = $this->streamManager->getOr404($streamId);
        $chat = $stream->getChat();

        return $this->json(['chat' => ['messages' => $chat->getMessages()]]);
    }
}
