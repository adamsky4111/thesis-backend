<?php

namespace App\Service\Viewer\Handler\Action;

use App\Entity\User\User;
use App\Service\Stream\Manager\StreamManagerInterface;
use App\Service\Viewer\Handler\EventContext;
use Doctrine\ORM\EntityManagerInterface;

final class StartStreamConnectionAction implements ConnectionEventActionInterface
{
    protected string $projectDir;
    protected StreamManagerInterface $manager;
    protected EntityManagerInterface $entityManager;

    public function __construct(string $projectDir, StreamManagerInterface $manager, EntityManagerInterface $entityManager)
    {
        $this->projectDir = $projectDir;
        $this->manager = $manager;
        $this->entityManager = $entityManager;
    }

    public function handle(EventContext $context): void
    {
        $dir = $this->projectDir.'/data/'.$context->getElement()->getStreamId();
        if (!file_exists($dir)) {
            mkdir($dir, 0777);
            file_put_contents($dir . '/info', "0");
        }
        unset($dir);

        /** @var User $user */
        $user = $this->entityManager->getRepository(User::class)->find($context->getElement()->getUserId());

        $this->manager->startStream($context->getElement()->getStreamId(), $user->getAccount());

        unset($user);

        echo "Rozpoczeto transmisje";
    }

    public function isEventSupported(EventContext $context): bool
    {
        return $context->getEvent() === 'start_stream';
    }
}