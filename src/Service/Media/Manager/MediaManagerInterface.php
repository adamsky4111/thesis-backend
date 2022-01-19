<?php

namespace App\Service\Media\Manager;

use App\Entity\User\Media;
use App\Entity\User\User;
use Symfony\Component\HttpFoundation\File\UploadedFile;

interface MediaManagerInterface
{
    public function uploadImage(User $user, UploadedFile $file): Media;
    public function resolvePath(Media $media): string;
}
