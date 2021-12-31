<?php

namespace App\Service\Channel\Subscriber;

use App\Entity\Stream\Channel;

interface ChannelSubscriberInterface
{
    public function subscribe(Channel $channel): bool;
    public function unsubscribe(Channel $channel): bool;

    /**
     * @return Channel[]
     */
    public function getSubscribed(): array;
}
