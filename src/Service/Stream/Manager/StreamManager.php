<?php

namespace App\Service\Stream\Manager;

use App\Dto\StreamDto;
use App\Entity\Stream\Stream;
use App\Entity\User\User;
use App\Event\EventDispatcherInterface;
use App\Event\Stream\StreamEvent;
use App\Filter\FilterInterface;
use App\Repository\Stream\StreamRepositoryInterface;
use App\Service\Stream\Context\ChannelContextInterface;
use App\Service\Stream\Factory\StreamFactoryInterface;
use App\Service\User\Context\AccountContextInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class StreamManager implements StreamManagerInterface
{
    public function __construct(
        protected StreamRepositoryInterface $streams,
        protected StreamFactoryInterface $factory,
        protected ChannelContextInterface $channel,
        protected AccountContextInterface $account,
        protected EventDispatcherInterface $dispatcher,
    ) {}

    public function searchByFilter(FilterInterface $filter): array
    {
        return $this->streams->searchByFilter($filter);
    }

    public function getUserActualStream(User $user): ?StreamDto
    {
        $stream = $user->getAccount()->getActualStream();

        return $stream ? StreamDto::createFromObject($stream) : null;
    }
    public function registerStream(StreamDto $dto): StreamDto
    {
        $stream = $this->factory->create($dto, $this->channel->getChannel());

        if ($stream->getIsActive()) {
            $this->startStream($stream);
        } else {
            $this->streams->save($stream);
        }

        return StreamDto::createFromObject($stream);
    }
    public function stopActualStream(): ?StreamDto
    {
        $account = $this->account->getAccount();
        $stream = $account->getActualStream();
        if ($stream instanceof Stream) {
            $stream->setIsActive(false);
            $account->setActualStream(null);
            $this->dispatcher->dispatch((new StreamEvent($stream)), StreamEvent::STREAM_STOP);
            $this->streams->save($stream);
        }

        return $stream ? StreamDto::createFromObject($stream) : null;
    }

    public function startStream(Stream $stream)
    {
        $this->stopActualStream();
        $stream->setIsActive(true);
        $account = $this->account->getAccount();
        $account->setActualStream($stream);
        $this->dispatcher->dispatch((new StreamEvent($stream)), StreamEvent::STREAM_START);
        $this->streams->save($stream);
    }

    public function getOr404(int $id): Stream
    {
        if (null === ($stream = $this->streams->findActive($id))) {
            throw new NotFoundHttpException();
        }

        return $stream;
    }

    public function get(int $id): StreamDto
    {
        return StreamDto::createFromObject($this->getOr404($id));
    }
}
