<?php

namespace App\Event\User;

use App\Entity\Stream\Channel;
use Symfony\Contracts\EventDispatcher\Event;

class ChannelEvent extends Event
{
    public const PRE_UPDATE = 'channel.updated.pre';
    public const POST_UPDATE = 'channel.updated.post';
    public const PRE_DELETE = 'channel.deleted.pre';
    public const POST_DELETE = 'channel.deleted.post';
    public const PRE_CREATE = 'channel.create.pre';
    public const POST_CREATE = 'channel.create.post';


    public function __construct(
        protected Channel $channel
    ) {}

    public function getChannel(): Channel
    {
        return $this->channel;
    }
}
