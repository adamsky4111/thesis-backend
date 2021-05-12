<?php

namespace App\Service\Stream\Factory;

use App\Dto\ChannelDto;
use App\Dto\SettingsDto;
use App\Entity\Stream\Channel;
use App\Entity\User\Account;
use App\Entity\User\Settings;
use Doctrine\ORM\EntityManagerInterface;
use function Couchbase\passthruEncoder;

final class DefaultChannelFactory implements ChannelFactoryInterface
{
    public function __construct(
        protected EntityManagerInterface $em,
        protected DefaultSettingsFactory $factorySetting,
    ) {}


    public function create(ChannelDto $dto, Account $account): Channel
    {
        $channel = new Channel($account->getDefaultSettings(), $account);
        if ($dto->isDefault()) {
            /** @var Channel $channel */
            foreach ($account->getChannels() as $channel) {
                $channel->setDefault(false);
            }
        }
        $settings = clone $account->getDefaultSettings();
        $this->em->persist($settings);

        $channel->setName($dto->getName());
        $channel->setDefault($dto->isDefault());
        $channel->setDescription($dto->getDescription());
        $channel->setAccount($account);
        $channel->setSettings($settings);
        $channel->setCreatedAt(new \DateTime());

        return $channel;
    }

    public function update(ChannelDto $dto, Channel $channel): Channel
    {
        $account = $channel->getAccount();

        if ($dto->isDefault()) {
            /** @var Channel $channel */
            foreach ($account->getChannels() as $channel) {
                $channel->setDefault(false);
            }
        }
        $channel->setName($dto->getName());
        $channel->setDefault($dto->isDefault());
        $channel->setDescription($dto->getDescription());
        $channel->setUpdatedAt(new \DateTime());
        $toRemove = $channel->getSettings();
        $account->removeSettings($toRemove);
        $toRemove->setAccount(null);
        $settings = $this->factorySetting->create($dto->getSettings(), $account);
        $this->em->persist($settings);
        $channel->setSettings($settings);
        $this->em->remove($channel->getSettings());


        return $channel;
    }
}
