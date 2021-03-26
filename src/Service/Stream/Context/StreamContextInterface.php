<?php

namespace App\Service\Stream\Context;

use App\Entity\Stream\Stream;

interface StreamContextInterface
{
    public function getStream(): ?Stream;
}
