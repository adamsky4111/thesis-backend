<?php

namespace App\Service\Stream\Manager;

use App\Dto\ChannelDto;
use App\Entity\Stream\Channel;
use App\Filter\FilterInterface;

interface ChannelManagerInterface
{
    public function getOr404(int $id): Channel;
    public function get(int $id): ChannelDto;
    public function create(ChannelDto $dto): ChannelDto;
    public function update(ChannelDto $dto, Channel $channel): ChannelDto;
    public function delete(Channel $channel): ChannelDto;
    public function getAccountChannels(FilterInterface $filter): array;
}
