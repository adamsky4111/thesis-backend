<?php

namespace App\Service\Mailer;

class EmailMessage extends AbstractMessage implements MessageInterface
{
    const RESTORE_PASSWORD = 'user.restore_password';
    const VERIFY_ACCOUNT = 'user.verify';
}
