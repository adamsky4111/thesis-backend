<?php

namespace App\Service\Viewer\Handler;

use App\Service\Viewer\Handler\Action\ConnectionEventActionInterface;

final class CompositeConnectionEventHandler implements ConnectionEventHandlerInterface
{
    /** @var ConnectionEventActionInterface[] */
    private iterable $actions;

    public function __construct(iterable $actions)
    {
        $this->actions = $actions;
    }

    public function handle(EventContext $context): void
    {
        foreach ($this->actions as $action) {
            if ($action->isEventSupported($context)) {
                $action->handle($context);

                return;
            }
        }
    }
}