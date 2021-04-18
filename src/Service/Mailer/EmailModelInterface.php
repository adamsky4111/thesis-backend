<?php

namespace App\Service\Mailer;

interface EmailModelInterface
{
    public function createResponseBody(): array;
    public function createTemplateData(): array;
    public function getMessageCode(): string;
    public function getTemplatePath(): string;
    public function getSubject(): string;
    public function getReceiveEmail(): string;
}
