<?php

namespace App\Service\Viewer\Handler\Action;

use App\Service\Viewer\Handler\EventContext;

interface ConnectionEventActionInterface
{
    public function handle(EventContext $context): void;
    public function isEventSupported(EventContext $context): bool;
}