<?php

namespace App\EventListener\User;

use App\Event\User\UserEvent;
use App\Service\Mailer\MailSenderInterface;
use App\Service\Mailer\Model\RestorePasswordModel;
use App\Service\Mailer\Model\VerifyAccountModel;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class AccountVerifierSubscriber implements EventSubscriberInterface
{
    public function __construct(
        protected UrlGeneratorInterface $generator,
        protected ParameterBagInterface $params,
        protected MailSenderInterface $sender,
    ) {}

    public static function getSubscribedEvents(): array
    {
        return [
            UserEvent::REGISTERED => 'sendVerify',
        ];
    }

    public function sendVerify(UserEvent $event)
    {
        $user = $event->getUser();
        $url = $this->params->get('verify_url') . '?token=' . $user->getConfirmationToken() . '&email=' . $user->getEmail();
        $model = new VerifyAccountModel($user, $url);
        $this->sender->send($model);
    }
}
