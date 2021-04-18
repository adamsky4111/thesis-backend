<?php

namespace App\Service\Mailer;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;

interface MessageInterface
{
    public function build(): self;
    public function getTemplate(): TemplatedEmail;
}
