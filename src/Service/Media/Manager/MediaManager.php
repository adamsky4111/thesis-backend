<?php

namespace App\Service\Media\Manager;

use App\Entity\User\Media;
use App\Entity\User\User;
use App\Service\Media\Factory\MediaFactoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

final class MediaManager implements MediaManagerInterface
{
    public function __construct(
        protected MediaFactoryInterface $factory,
        protected string $projectDir,
        protected EntityManagerInterface $entityManager,
    ){}

    public function uploadImage(User $user, UploadedFile $file): Media
    {
        $media = $this->factory->createImage($user);
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $media->setOriginalFilename($originalFilename);
        $media->setSize($file->getSize());
        $media->setFilename(md5(uniqid()) . '.' . $file->getClientOriginalExtension());
        try {
            $file->move($this->projectDir.'/public/uploads/img/', $media->getFilename());
        } catch (FileException $exception) {
            throw new UnprocessableEntityHttpException($exception->getMessage());
        }
        $this->entityManager->persist($media);
        $this->entityManager->flush();

        return $media;
    }

    public function resolvePath(Media $media): string
    {
        return $this->projectDir.'/public/uploads/img/'.$media->getFilename();
    }
}
