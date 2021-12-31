<?php

namespace App\Service\Viewer;

use Ratchet\ConnectionInterface;

final class ConnectionSocketElement
{
    public int $streamId;
    public string $jwt;
    public ConnectionInterface $connection;
}
