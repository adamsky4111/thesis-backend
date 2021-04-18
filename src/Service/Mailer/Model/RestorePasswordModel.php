<?php

namespace App\Service\Mailer\Model;

use App\Entity\User\User;
use App\Service\Mailer\EmailMessage;
use App\Service\Mailer\EmailModelInterface;

class RestorePasswordModel implements EmailModelInterface
{
    public function __construct(
        protected User $user,
        protected string $url,
    ) {}

    public function getMessageCode(): string
    {
        return EmailMessage::RESTORE_PASSWORD;
    }

    public function getTemplatePath(): string
    {
        return 'email/restore_password.html.twig';
    }

    public function getSubject(): string
    {
        return 'Odzyskiwanie hasła';
    }

    public function createResponseBody(): array
    {
        return [];
    }

    public function createTemplateData(): array
    {
        return [
            'url' => $this->url,
            'user' => $this->user,
        ];
    }

    public function getReceiveEmail(): string
    {
        return $this->user?->getEmail();
    }
}
