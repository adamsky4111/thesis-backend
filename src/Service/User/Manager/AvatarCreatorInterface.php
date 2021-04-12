<?php

namespace App\Service\User\Manager;

use App\Entity\User\Media;
use App\Entity\User\User;
use Symfony\Component\HttpFoundation\File\UploadedFile;

interface AvatarCreatorInterface
{
    public function newAvatar(User $user, UploadedFile $file): Media;
    public function resolveAvatarPath(string $path): string;
}
