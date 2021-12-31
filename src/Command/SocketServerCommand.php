<?php

namespace App\Command;

use App\Service\Viewer\SocketViewerHandler;
use Doctrine\ORM\EntityManagerInterface;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SocketServerCommand extends Command
{
    protected EntityManagerInterface $manager;

    public function __construct(EntityManagerInterface $manager, string $name = null)
    {
        parent::__construct($name);
        $this->manager = $manager;
    }

    protected function configure()
    {
        $this
            ->setName('app:viewer:server')
            ->setDescription('Start the notification server.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $port = 8080;
        $server = IoServer::factory(new HttpServer(
            new WsServer(
                new SocketViewerHandler($this->manager, $output)
            )
        ), $port, '0.0.0.0');
        $output->writeln('Server start on port '.$server->socket->getAddress());
        $server->run();
    }
}