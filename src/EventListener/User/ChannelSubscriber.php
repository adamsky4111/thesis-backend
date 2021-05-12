<?php

namespace App\EventListener\User;

use App\Event\User\ChannelEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ChannelSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            ChannelEvent::PRE_UPDATE => 'preUpdate',
            ChannelEvent::PRE_CREATE => 'preCreate',
        ];
    }

    public function preUpdate(ChannelEvent $event)
    {
        $channel = $event->getChannel();
        $channel->setUpdatedAt(new \DateTime());
    }

    public function preCreate(ChannelEvent $event)
    {
        $channel = $event->getChannel();
        $channel->setCreatedAt(new \DateTime());
        $channel->setUpdatedAt(new \DateTime());
    }
}
