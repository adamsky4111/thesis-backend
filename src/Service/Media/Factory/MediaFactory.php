<?php

namespace App\Service\Media\Factory;

use App\Entity\User\Media;
use App\Entity\User\User;

final class MediaFactory implements MediaFactoryInterface
{
    public function createImage(User $user): Media
    {
        $media = new Media();
        $media->setOwner($user);
        $media->setType(Media::IMAGE);

        return $media;
    }
    public function createVideo(User $user): Media
    {
        $media = new Media();
        $media->setOwner($user);
        $media->setType(Media::VIDEO);

        return $media;
    }
}
