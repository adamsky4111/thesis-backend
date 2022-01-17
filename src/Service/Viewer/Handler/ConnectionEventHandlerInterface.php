<?php

namespace App\Service\Viewer\Handler;

interface ConnectionEventHandlerInterface
{
    public function handle(EventContext $context): void;
}