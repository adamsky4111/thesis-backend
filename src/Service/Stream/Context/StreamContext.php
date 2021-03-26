<?php

namespace App\Service\Stream\Context;

use App\Entity\Stream\Stream;
use App\Service\User\Context\AccountContextInterface;

final class StreamContext implements StreamContextInterface
{
    public function __construct(
        protected AccountContextInterface $account,
    ) {}

    public function getStream(): ?Stream
    {
        return $this->account->getAccount()?->getActualStream();
    }
}
