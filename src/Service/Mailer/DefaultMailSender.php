<?php

namespace App\Service\Mailer;

use App\Service\Mailer\MailSenderInterface as BaseMailer;
use Symfony\Component\Mailer\MailerInterface;

class DefaultMailSender implements BaseMailer
{
    public function __construct(
        protected MailerInterface $mailer,
    ) {}

    public function send(EmailModelInterface $model)
    {
        $message = new EmailMessage($model);

        $this->mailer->send($message->getTemplate());

        return $model->createResponseBody();
    }
}
