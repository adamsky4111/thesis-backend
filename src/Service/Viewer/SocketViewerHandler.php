<?php

namespace App\Service\Viewer;

use App\Entity\Stream\Stream;
use Doctrine\ORM\EntityManagerInterface;
use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SocketViewerHandler implements MessageComponentInterface
{
    /**
     * @var ConnectionSocketElement[]
     */
    protected array $connections = [];
    protected EntityManagerInterface $manager;
    protected OutputInterface $output;

    public function __construct(EntityManagerInterface $manager, OutputInterface $output)
    {
        $this->manager = $manager;
        $this->output = $output;
    }

    /**
     * @param ConnectionInterface $conn
     */
    public function onOpen(ConnectionInterface $conn)
    {
        $item = new ConnectionSocketElement();
        $item->connection = $conn;
        $this->connections[] = $item;
//        $this->output->writeln('test');
    }

    /**
     * @param ConnectionInterface $from
     * @param string $msg
     */
    public function onMessage(ConnectionInterface $from, $msg)
    {
        $this->output->writeln($msg);
//        $data = \json_decode($msg);
        foreach ($this->connections as $connection) {
//            if ($from !== $connection->connection) {
                $connection->connection->send($msg);
//                $connection->streamId = $data['streamId'];
//                $connection->jwt = $data['jwt'];
//                $this->fixStreamViewer($connection, true);
//            }
        }
    }

    /**
     * @param ConnectionInterface $conn
     */
    public function onClose(ConnectionInterface $conn)
    {
//        foreach($this->connections as $key => $element){
//            if($conn === $element->connection){
////                $this->fixStreamViewer($element, false);
//                unset($this->connections[$key]);
//                break;
//            }
//        }
    }

    /**
     * @param ConnectionInterface $conn
     * @param \Exception $e
     */
    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        $conn->send("Error : " . $e->getMessage());
        $conn->close();
    }

    protected function fixStreamViewer(ConnectionSocketElement $element, bool $add)
    {
        $em = $this->manager;
        $repo = $em->getRepository(Stream::class);

        /** @var Stream $stream */
        $stream = $repo->find($element->streamId);

        $stream->setWatchersCount($stream->getWatchersCount() + ($add ? 1 : -1));
        echo sprintf('Użytkownik %s %s do transmisji o ID: %s', 'test', $add ? 'dółączył' : 'opuścił', $element->streamId);

        $em->flush();
    }
}