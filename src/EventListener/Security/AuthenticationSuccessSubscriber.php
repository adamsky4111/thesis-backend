<?php

namespace App\EventListener\Security;

use App\Entity\User\User;
use App\Serializer\UserSerializer;
use App\Service\User\Dto\UserDto;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Events;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class AuthenticationSuccessSubscriber implements EventSubscriberInterface
{
    public function __construct(
        protected UserSerializer $serializer,
    ) {}

    public static function getSubscribedEvents(): array
    {
        return [
            Events::AUTHENTICATION_SUCCESS => 'addResponseData',
        ];
    }

    public function addResponseData(AuthenticationSuccessEvent $event)
    {
        $user = $event->getUser();
        $data = $event->getData();
        if ($user instanceof User) {
            $data['user'] = $this->serializer->normalize(UserDto::createFromUser($user));
        }
        $data['roles'] = $user->getRoles();

        $event->setData($data);
    }
}
