<?php

namespace App\Event\Stream;

use App\Entity\Stream\Stream;
use App\Entity\User\User;
use Symfony\Contracts\EventDispatcher\Event;

class StreamEvent extends Event
{
    public const STREAM_START = 'stream.start';
    public const STREAM_STOP = 'stream.stop';

    public function __construct(
        protected Stream $stream
    ) {}

    public function getUser(): Stream
    {
        return $this->stream;
    }
}
