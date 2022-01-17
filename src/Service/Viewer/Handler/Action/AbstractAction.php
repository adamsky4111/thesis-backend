<?php

namespace App\Service\Viewer\Handler\Action;

use App\Service\Viewer\Handler\EventContext;

abstract class AbstractAction implements ConnectionEventActionInterface
{
    abstract function action(EventContext $context): void;
    abstract function getEventName(): string;

    public function handle(EventContext $context): void
    {
        if (!$this->isEventSupported($context)) {
            throw new WrongEventException();
        }

        $this->action($context);
    }

    public function isEventSupported(EventContext $context): bool
    {
        return $context->getEvent() === $this->getEventName();
    }

    protected function createResponse(array $data): string
    {
        $data['event'] = $this->getEventName();

        return \json_encode($data);
    }
}