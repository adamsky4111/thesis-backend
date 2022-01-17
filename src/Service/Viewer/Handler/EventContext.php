<?php

namespace App\Service\Viewer\Handler;

use App\Service\Viewer\ConnectionSocketElement;

final class EventContext
{
    protected ?ConnectionSocketElement $element;
    protected array $data;
    protected string $event;

    public function __construct(ConnectionSocketElement $element, string $event, array $data = [])
    {
        $this->element = $element;
        $this->event = $event;
        $this->data = $data;
    }

    public function getElement(): ConnectionSocketElement
    {
        return $this->element;
    }

    public function getEvent(): string
    {
        return $this->event;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function reset(): void
    {
        $this->element = null;
        $this->data = [];
    }
}