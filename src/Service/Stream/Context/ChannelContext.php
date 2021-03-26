<?php

namespace App\Service\Stream\Context;

use App\Entity\Stream\Channel;
use App\Service\User\Context\AccountContextInterface;

final class ChannelContext
{
    public function __construct(
        protected AccountContextInterface $account,
    ) {}

    public function getChannel(): ?Channel
    {
       $account = $this->account->getAccount();

       return $account->getDefaultChannel();
    }
}
