<?php

namespace App\Service\Stream\Manager;

use App\Dto\ChannelDto;
use App\Entity\Stream\Channel;
use App\Event\EventDispatcherInterface;
use App\Event\User\ChannelEvent;
use App\Filter\FilterInterface;
use App\Repository\Stream\ChannelRepositoryInterface;
use App\Service\Stream\Factory\ChannelFactoryInterface;
use App\Service\User\Context\AccountContextInterface;
use JetBrains\PhpStorm\ArrayShape;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class ChannelManager implements ChannelManagerInterface
{
    public function __construct(
        protected AccountContextInterface $account,
        protected ChannelRepositoryInterface $channels,
        protected ChannelFactoryInterface $factory,
        protected EventDispatcherInterface $dispatcher,
    ) {}

    public function getOr404(int $id): Channel
    {
        $channel = $this->channels->find($id);

        if (null === $channel) {
            throw new NotFoundHttpException();
        }

        return $channel;
    }

    public function get(int $id): ChannelDto
    {
        $channel = $this->getOr404($id);

        return ChannelDto::createFromObject($channel);
    }

    public function create(ChannelDto $dto): ChannelDto
    {
        $channel = $this->factory->create($dto, $this->account->getAccount());
        $this->dispatcher->dispatch((new ChannelEvent($channel)), ChannelEvent::PRE_CREATE);
        $this->channels->save($channel);
        $this->dispatcher->dispatch((new ChannelEvent($channel)), ChannelEvent::POST_CREATE);

        return ChannelDto::createFromObject($channel);
    }

    public function update(ChannelDto $dto, Channel $channel): ChannelDto
    {

        $channel = $this->factory->update($dto, $channel);
        $this->dispatcher->dispatch((new ChannelEvent($channel)), ChannelEvent::PRE_UPDATE);
        $this->channels->save($channel);
        $this->dispatcher->dispatch((new ChannelEvent($channel)), ChannelEvent::POST_UPDATE);

        return ChannelDto::createFromObject($channel);
    }

    public function delete(Channel $channel): ChannelDto
    {
        $this->dispatcher->dispatch((new ChannelEvent($channel)), ChannelEvent::PRE_DELETE);
        $channel = $this->channels->remove($channel);
        $this->dispatcher->dispatch((new ChannelEvent($channel)), ChannelEvent::POST_DELETE);

        return ChannelDto::createFromObject($channel);
    }

    #[ArrayShape([
        'items' => "array",
        'total' => "int",
        'pages' => "int"
    ])]
    public function getAccountChannels(FilterInterface $filter): array
    {
        return $this->channels->findAllByFilter($this->account->getAccount(), $filter);
    }
}
