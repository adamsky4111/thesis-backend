<?php

namespace App\Service\Chat\Manager;

use App\Dto\MessageDto;
use App\Entity\Stream\Chat;
use App\Entity\Stream\Message;

interface ChatManagerInterface
{
    public function getOr404(int $id): Chat;
    public function getMessage(int $id): Message;
    public function addMessage(MessageDto $dto, Chat $chat): MessageDto;
    public function removeMessage(Message $message): MessageDto;
}
