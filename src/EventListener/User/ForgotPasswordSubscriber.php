<?php

namespace App\EventListener\User;

use App\Event\User\UserEvent;
use App\Service\Mailer\MailSenderInterface;
use App\Service\Mailer\Model\RestorePasswordModel;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ForgotPasswordSubscriber implements EventSubscriberInterface
{
    public function __construct(
        protected UrlGeneratorInterface $generator,
        protected ParameterBagInterface $params,
        protected MailSenderInterface $sender,
    ) {}

    public static function getSubscribedEvents(): array
    {
        return [
            UserEvent::RESTORE_PASSWORD_TOKEN_GENERATED => 'sendRestore',
        ];
    }

    public function sendRestore(UserEvent $event)
    {
        $user = $event->getUser();
        $url = $this->params->get('forgot_pass_url') . '?token=' . $user->getConfirmationToken() . '&email=' . $user->getEmail();
        $model = new RestorePasswordModel($user, $url);
        $this->sender->send($model);
    }
}
