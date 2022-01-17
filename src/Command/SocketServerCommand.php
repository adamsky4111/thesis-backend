<?php

namespace App\Command;

use App\Service\Viewer\Handler\ConnectionEventHandlerInterface;
use App\Service\Viewer\SocketViewerHandler;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SocketServerCommand extends Command
{
    protected EntityManagerInterface $manager;
    protected JWTTokenManagerInterface $token;
    protected ConnectionEventHandlerInterface $handler;

    public function __construct(EntityManagerInterface $manager, JWTTokenManagerInterface $token, ConnectionEventHandlerInterface $handler, string $name = null)
    {
        parent::__construct($name);
        $this->manager = $manager;
        $this->token = $token;
        $this->handler = $handler;
    }

    protected function configure()
    {
        $this
            ->setName('app:viewer:server')
            ->setDescription('Start the notification server.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $port = 9090;
        $server = IoServer::factory(
            new HttpServer(
                new WsServer(
                    new SocketViewerHandler($this->manager, $this->token, $output, $this->handler),
                )
            ),
            $port
        );
        $output->writeln('Server start on port '.$server->socket->getAddress());
        $server->run();
    }
}