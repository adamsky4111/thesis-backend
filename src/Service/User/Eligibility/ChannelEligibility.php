<?php

namespace App\Service\User\Eligibility;

use App\Entity\User\Account;

final class ChannelEligibility
{
    public function createChannelEligibility(Account $account): bool
    {
       $default = $account->getDefaultSettings();

       return (null !== $default);
    }
}
