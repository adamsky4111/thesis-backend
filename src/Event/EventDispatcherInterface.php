<?php

namespace App\Event;

use Symfony\Contracts\EventDispatcher\Event;

interface EventDispatcherInterface
{
    public function dispatch(Event $event, string $name);
}
