<?php

namespace App\Service\User\Manager;

use App\Entity\User\Media;
use App\Entity\User\User;
use App\Provider\AppUrlProviderInterface;
use App\Service\Media\Factory\MediaFactoryInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

final class DefaultAvatarCreator implements AvatarCreatorInterface
{
    public function __construct(
        protected MediaFactoryInterface $factory,
        protected AppUrlProviderInterface $url,
    ) {}

    public function newAvatar(User $user, UploadedFile $file): Media
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $media = $this->factory->createImage($user);
        $media->setOriginalFilename($originalFilename);
        $media->setSize($file->getSize());
        $media->setFilename(md5(uniqid()) . '.' . $file->getClientOriginalExtension());

        try {
            $file->move('../public/uploads/img/', $media->getFilename());
        } catch (FileException $exception) {
            throw new UnprocessableEntityHttpException($exception->getMessage());
        }

        return $media;
    }

    public function resolveAvatarPath(string $path): string
    {
        return $this->url->getHostUrl() . '/uploads/img/' . $path;
    }

}
