<?php

namespace App\Service\Viewer;

use App\Entity\Stream\Stream;
use App\Entity\User\User;
use App\Service\Viewer\Handler\ConnectionEventHandlerInterface;
use App\Service\Viewer\Handler\EventContext;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Authentication\Token\JWTUserToken;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * flow - onOpen register connection, then if backend sent to front - success,
 * frontend is sending stream and user data - if only user is logged, jwt token is send
 */
class SocketViewerHandler implements MessageComponentInterface
{
    /**
     * @var ConnectionSocketElement[]
     */
    protected array $connections = [];
    protected EntityManagerInterface $manager;
    protected JWTTokenManagerInterface $token;
    protected OutputInterface $output;
    protected ConnectionEventHandlerInterface $handler;

    public function __construct(EntityManagerInterface $manager, JWTTokenManagerInterface $token, OutputInterface $output, ConnectionEventHandlerInterface $handler)
    {
        $this->manager = $manager;
        $this->token = $token;
        $this->output = $output;
        $this->handler = $handler;
    }

    public function onOpen(ConnectionInterface $conn)
    {
        $item = new ConnectionSocketElement();
        $item->setConnection($conn);
        $this->connections[] = $item;
        $this->output->writeln('New connection');
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        $data = \json_decode($msg, true);
        foreach ($this->connections as $connection) {
            echo $from === $connection->getConnection() ? 'true' : 'false';
            if ($from === $connection->getConnection()) {
                echo $connection->isConnected() ? 'connected' : 'not yet connecter';
                // jeżeli jest połączenie zarejestrowane
                if ($connection->isConnected()) {
                    $ar = [];
                    // znalezienie połączeń wyjściowych (do kogo kierowane są dane)
                    foreach ($this->connections as $con) {
                        if ($connection->getStreamId() === $con->getStreamId() && $from !== $con->getConnection()) {
                            $ar[] = $con;
                        }
                    }
                    $event = $data['event'];
                    unset($data['event']);
                    $data['viewers'] = $ar;
                    echo PHP_EOL . "Tworzenie kontekstu...";
                    // stworzenie kontekstu i obsługa eventu
                    $context = new EventContext($connection, $event, $data);
                    echo PHP_EOL . "Tworzenie eventu...";

                    $this->handler->handle($context);
                    // jako, że jest to połączenie socketowe nie i/o musi występować zwolnienie pamięci
                    // garbage collector usunie z pamięci obiekt przy nastepnym cyklu procesora
                    $context->reset();
                    unset($context);

                    return;
                }
                // if streamId is not send, close connection
                if (!$data['streamId']) {
                    $connection->getConnection()->close();
                }
                $connection->setStreamId($data['streamId']);
                if (isset($data['jwt'])) {
                    $connection->setJwt($data['jwt']);
                    $this->resolveUserAndSetUserId($connection);
                }
                $connection->setConnected(true);
                $this->fixStreamViewer($connection, true);
            }
        }
    }

    public function onClose(ConnectionInterface $conn)
    {
        foreach($this->connections as $key => $element){
            if($conn === $element->getConnection()){
                $this->fixStreamViewer($element, false);
                unset($this->connections[$key]);
                break;
            }
        }
    }

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
        $stream = $repo->find($element->getStreamId());
        $stream->setWatchersCount($stream->getWatchersCount() + ($add ? 1 : -1));
        $em->flush();
    }

    protected function resolveUserAndSetUserId(ConnectionSocketElement $element)
    {
        $token = new JWTUserToken();
        $token->setRawToken($element->getJwt());
        $payload = $this->token->decode($token);
        $repo = $this->manager->getRepository(User::class);
        $user = $repo->findOneBy(['username' => $payload['username']]);
        echo $user->getId() . ' Ogląda stream o id: '.$element->getStreamId();
        $element->setUserId($user->getId());
    }
}