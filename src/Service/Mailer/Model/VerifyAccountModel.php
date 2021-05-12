<?php

namespace App\Service\Mailer\Model;

use App\Entity\User\User;
use App\Service\Mailer\EmailMessage;
use App\Service\Mailer\EmailModelInterface;

class VerifyAccountModel implements EmailModelInterface
{
    public function __construct(
        protected User $user,
        protected string $url,
    ) {}

    public function getMessageCode(): string
    {
        return EmailMessage::VERIFY_ACCOUNT;
    }

    public function getTemplatePath(): string
    {
        return 'email/user_verify.html.twig';
    }

    public function getSubject(): string
    {
        return 'Weryfikacja konta na ProStream';
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
