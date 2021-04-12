<?php

namespace App\Service\Media\Factory;

use App\Entity\User\Media;
use App\Entity\User\User;

interface MediaFactoryInterface
{
    public function createImage(User $user): Media;
    public function createVideo(User $user): Media;
}
