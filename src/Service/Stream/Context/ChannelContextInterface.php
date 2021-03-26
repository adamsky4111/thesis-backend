<?php

namespace App\Service\Stream\Context;

use App\Entity\Stream\Channel;

interface ChannelContextInterface
{
    public function getChannel(): ?Channel;
}
