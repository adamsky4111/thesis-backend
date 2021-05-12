<?php

namespace App\Service\Stream\Factory;

use App\Dto\ChannelDto;
use App\Entity\Stream\Channel;
use App\Entity\User\Account;

interface ChannelFactoryInterface
{
    public function create(ChannelDto $dto, Account $account): Channel;
    public function update(ChannelDto $dto, Channel $channel): Channel;
}
