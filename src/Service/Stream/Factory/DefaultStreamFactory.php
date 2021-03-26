<?php

namespace App\Service\Stream\Factory;

use App\Dto\StreamDto;
use App\Entity\Stream\Channel;
use App\Entity\Stream\Stream;
use App\Entity\User\Settings;
use App\Service\Stream\Factory\StreamFactoryInterface;
use App\Service\User\Dto\Dto;
use Doctrine\ORM\EntityManagerInterface;

final class DefaultStreamFactory implements StreamFactoryInterface
{
    public function __construct(
        protected EntityManagerInterface $em,
    ) {}

    public function create(StreamDto $dto, Channel $channel): Stream
    {
        $settings = new Settings();
        $settings->setName($dto->getName());
        $settings->setAgeAllowed($dto->getAgeAllowed());
        $settings->setIsDefault(false);

        $this->em->persist($settings);

        $stream = new Stream($settings);
        $stream->setIsActive($dto->isStartNow());
        $stream->setChannel($channel);
        $stream->setName($dto->getName());
        $stream->setDescription($dto->getDescription());
        $stream->setStartingAt($dto->isStartNow() ? new \DateTime() : $dto->getStartingAt());
        $stream->setEndingAt($dto->getEndingAt());

        $this->em->persist($stream);

        return $stream;
    }
}
