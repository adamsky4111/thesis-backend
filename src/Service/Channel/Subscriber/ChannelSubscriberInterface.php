<?php

namespace App\Service\Channel\Subscriber;

use App\Entity\Stream\Channel;
use App\Entity\User\AccountChannelSubscribe;

interface ChannelSubscriberInterface
{
    public function subscribe(Channel $channel): bool;
    public function unsubscribe(Channel $channel): bool;

    /**
     * @return AccountChannelSubscribe[]
     */
    public function getSubscribed(): array;
}
