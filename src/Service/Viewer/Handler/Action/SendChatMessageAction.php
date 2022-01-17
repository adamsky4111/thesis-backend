<?php

namespace App\Service\Viewer\Handler\Action;

use App\Entity\Stream\Message;
use App\Entity\Stream\Stream;
use App\Entity\User\User;
use App\Service\User\Manager\AvatarCreatorInterface;
use App\Service\Viewer\ConnectionSocketElement;
use App\Service\Viewer\Handler\EventContext;
use Doctrine\ORM\EntityManagerInterface;

final class SendChatMessageAction extends AbstractAction implements ConnectionEventActionInterface
{
    protected string $projectDir;
    protected EntityManagerInterface $entityManager;
    protected AvatarCreatorInterface $avatarCreator;

    public function __construct(string $projectDir, EntityManagerInterface $entityManager, AvatarCreatorInterface $avatarCreator)
    {
        $this->projectDir = $projectDir;
        $this->entityManager = $entityManager;
        $this->avatarCreator = $avatarCreator;
    }

    function action(EventContext $context): void
    {
        $data = $context->getData();
        $stream = $this->entityManager->getRepository(Stream::class)->find($context->getElement()->getStreamId());
        if (!$stream instanceof Stream) {
            return;
        }
        $user = $this->entityManager->getRepository(User::class)->find($context->getElement()->getUserId());
        if (!$user instanceof User) {
            return;
        }
        $message = new Message($user, $stream->getChat(), $data['message']);
        $this->entityManager->persist($message);
        $this->entityManager->flush();
        $response = $this->createResponse(['message' => [
            'text' => $message->getContent(),
            'chatId' => $message->getChat()->getId(),
            'nick' => $user->getAccount()->getAccountInformation()->getNick(),
            'id' => $message->getId(),
            'username' => $message->getUser()->getUsername(),
            'avatar' => $this->avatarCreator->resolveAvatarPath($message
                ->getUser()
                ?->getAccount()
                ?->getAvatar()
                ?->getFilename()),
            'createdAt' => $message->getCreatedAt(),
        ]]);
        /** @var ConnectionSocketElement $element */
        foreach ($context->getData()['viewers'] as $element) {
            $element->getConnection()->send($response);
        }
        $context->getElement()->getConnection()->send($response);
    }

    function getEventName(): string
    {
        return 'chat_message';
    }
}