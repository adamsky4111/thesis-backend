<?php

namespace App\Service\Mailer;

interface MailSenderInterface
{
    public function send(EmailModelInterface $model);
}
