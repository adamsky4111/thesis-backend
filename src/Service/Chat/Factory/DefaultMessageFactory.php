<?php

namespace App\Service\Chat\Factory;

use App\Dto\MessageDto;
use App\Entity\Stream\Chat;
use App\Entity\Stream\Message;
use App\Entity\User\User;
use Doctrine\ORM\EntityManagerInterface;

final class DefaultMessageFactory implements MessageFactoryInterface
{
    public function __construct(
        protected EntityManagerInterface $em,
    ) {}

    public function create(MessageDto $dto, Chat $chat, User $user): Message
    {
        $message = new Message($user, $chat, $dto->getText());

        $chat->addMessage($message);
        $message->setCreatedAt(new \DateTime());
        $this->em->persist($message);

        return $message;
    }
}
