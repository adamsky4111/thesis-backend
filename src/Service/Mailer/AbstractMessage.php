<?php

namespace App\Service\Mailer;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;

abstract class AbstractMessage implements MessageInterface
{
    protected EmailModelInterface $model;
    protected ?TemplatedEmail $template = null;

    public function __construct(EmailModelInterface $model)
    {
        $this->model = $model;
        $this->build();
    }

    public function build(): self
    {
        $this->template = (new TemplatedEmail())
            ->from('main@prostream.com')
            ->to($this->model->getReceiveEmail())
            ->subject($this->model->getSubject())
            ->htmlTemplate($this->model->getTemplatePath())
            ->context($this->model->createTemplateData());

        return $this;
    }

    public function getTemplate(): TemplatedEmail
    {
        if (null === $this->template) {
            throw new \UnexpectedValueException();
        }

        return $this->template;
    }
}
