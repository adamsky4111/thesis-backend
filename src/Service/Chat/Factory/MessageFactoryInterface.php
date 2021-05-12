<?php

namespace App\Service\Chat\Factory;

use App\Dto\MessageDto;
use App\Entity\Stream\Chat;
use App\Entity\Stream\Message;
use App\Entity\User\User;

interface MessageFactoryInterface
{
    public function create(MessageDto $dto, Chat $chat, User $user): Message;
}
