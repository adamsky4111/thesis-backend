<?php

namespace App\Event;

use Symfony\Contracts\EventDispatcher\EventDispatcherInterface as BaseEventDispatcher;

final class EventDispatcher implements EventDispatcherInterface
{
    public function __construct(
        private BaseEventDispatcher $dispatcher,
    ) {}

    public function dispatch($event, $name)
    {
        $this->dispatcher->dispatch($event, $name);
    }
}
