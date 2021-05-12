<?php

namespace App\Service\Chat\Manager;

use App\Dto\MessageDto;
use App\Entity\Stream\Chat;
use App\Entity\Stream\Message;
use App\Repository\Stream\ChatRepositoryInterface;
use App\Repository\Stream\MessageRepositoryInterface;
use App\Service\Chat\Factory\MessageFactoryInterface;
use App\Service\User\Context\UserContextInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class ChatManager implements ChatManagerInterface
{
    public function __construct(
        protected MessageRepositoryInterface $messages,
        protected ChatRepositoryInterface $chats,
        protected MessageFactoryInterface $messageFactory,
        protected UserContextInterface $user,
        protected EntityManagerInterface $em,
    ) {}

    public function getOr404(int $id): Chat
    {
        $chat = $this->chats->findActive($id);
        if (null === $chat) {
            throw new NotFoundHttpException();
        }

        return $chat;
    }

    public function getMessage(int $id): Message
    {
        return $this->messages->findActive($id);
    }

    public function addMessage(MessageDto $dto, Chat $chat): MessageDto
    {
        $user = $this->user->getUser();
        $message = $this->messageFactory->create($dto, $chat, $user);
        $this->em->persist($message);
        $this->em->flush();

        return MessageDto::createFromObject($message);
    }

    public function removeMessage(Message $message): MessageDto
    {
        $message->setDeletedAt(new \DateTime());
        $message->setIsDeleted(true);
        $this->em->flush();

        return MessageDto::createFromObject($message);
    }
}
