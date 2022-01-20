<?php

namespace App\Service\Stream\Factory;

use App\Dto\SettingsDto;
use App\Dto\StreamDto;
use App\Entity\Stream\Channel;
use App\Entity\Stream\Stream;
use App\Service\StreamSchedule\ScheduleApplier\StreamScheduleApplierInterface;
use Doctrine\ORM\EntityManagerInterface;

final class DefaultStreamFactory implements StreamFactoryInterface
{
    public function __construct(
        protected EntityManagerInterface         $em,
        protected SettingsFactoryInterface $settingsFactory,
        protected StreamScheduleApplierInterface $schedule,
    ) {}

    public function create(StreamDto $dto, Channel $channel): Stream
    {
        if (null === $settingsDto = $dto->getSettings()) {
            $settingsDto = SettingsDto::createFromObject($channel->getSettings());
        }
        $settings = $this->settingsFactory->create($settingsDto, $channel->getAccount());
        $this->em->persist($settings);
        $stream = new Stream($settings);
        $stream->setIsActive($dto->isStartNow());
        $stream->setChannel($channel);
        $stream->setName($dto->getName());
        $stream->setDescription($dto->getDescription());
        $stream->setWatchersCount(0);
        $stream->setStartingAt($dto->isStartNow() ? new \DateTime() : $dto->getStartingAt());
        if (!$dto->isStartNow()) {
            $this->schedule->schedule($stream);
        }
        $stream->setEndingAt($dto->getEndingAt());
        $this->em->persist($stream);

        return $stream;
    }
}
