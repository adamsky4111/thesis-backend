<?php

namespace App\Service\Viewer;

use Ratchet\ConnectionInterface;

final class ConnectionSocketElement
{
    private ?int $streamId = null;
    private bool $connected = false;
    private ?int $userId = null;
    private ?string $jwt = null;
    private ConnectionInterface $connection;

    /**
     * @return int
     */
    public function getStreamId(): ?int
    {
        return $this->streamId;
    }

    /**
     * @param int $streamId
     */
    public function setStreamId(int $streamId): void
    {
        $this->streamId = $streamId;
    }

    /**
     * @return bool
     */
    public function isConnected(): bool
    {
        return $this->connected;
    }

    /**
     * @param bool $connected
     */
    public function setConnected(bool $connected): void
    {
        $this->connected = $connected;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     */
    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    /**
     * @return string
     */
    public function getJwt(): string
    {
        return $this->jwt;
    }

    /**
     * @param string $jwt
     */
    public function setJwt(string $jwt): void
    {
        $this->jwt = $jwt;
    }

    /**
     * @return ConnectionInterface|null
     */
    public function getConnection(): ?ConnectionInterface
    {
        return $this->connection;
    }

    /**
     * @param ConnectionInterface|null $connection
     */
    public function setConnection(?ConnectionInterface $connection): void
    {
        $this->connection = $connection;
    }
}
