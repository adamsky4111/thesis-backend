<?php

namespace App\EventListener\User;

use App\Event\User\UserEvent;
use JetBrains\PhpStorm\ArrayShape;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UserSubscriber implements EventSubscriberInterface
{
    #[ArrayShape([
        UserEvent::PRE_DELETE => "string",
        UserEvent::PRE_UPDATE => "string",
        UserEvent::PRE_CREATE => "string"
    ])] public static function getSubscribedEvents(): array
    {
        return [
            UserEvent::PRE_DELETE => 'preDelete',
            UserEvent::PRE_UPDATE => 'preUpdate',
            UserEvent::PRE_CREATE => 'preCreate',
        ];
    }

    public function preDelete(UserEvent $event)
    {
        $user = $event->getUser();
        $user->setDeletedAt(new \DateTime());
    }

    public function preUpdate(UserEvent $event)
    {
        $user = $event->getUser();
        $user->setUpdatedAt(new \DateTime());
    }

    public function preCreate(UserEvent $event)
    {
        $user = $event->getUser();
        $user->setCreatedAt(new \DateTime());
    }
}
