<?php

namespace App\Controller\Api;

use App\Serializer\UserSerializer;
use App\Service\User\Context\UserContextInterface;
use App\Service\User\Dto\UserDto;
use App\Service\User\Manager\UserManagerInterface;
use App\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/account", name="api_account_")
 */
class AccountController extends AbstractController
{
    public function __construct(
        protected UserSerializer $serializer,
        protected ValidatorInterface $validator,
        protected UserManagerInterface $manager,
        protected UserContextInterface $user,
    ) {}

    /**
     * @Route("/edit", name="edit")
     */
    public function editAction(Request $request): JsonResponse
    {
        try {
            /** @var UserDto $user */
            $user = $this->serializer->denormalize($request->getContent());
        } catch (\Exception) {
            return $this->json(['errors' => 'wrong json format'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $loggedUser = $this->user->getUser();

        if (!$user) {
            throw $this->createNotFoundException();
        }

        if ($this->validator->validate($user, [UserDto::GROUP_UPDATE])) {
            return $this->json(['errors' => $this->validator->getErrors()]);
        }

        $user = $this->manager->update($user, $loggedUser);

        return $this->json(['user' => $user]);
    }

    /**
     * @Route("/media", name="add_media", methods={"POST, GET"})
     */
    public function addMedia(Request $request): JsonResponse
    {
        try {
            /** @var UserDto $user */
            $file = $request->files->get('file');
        } catch (\Exception) {
            return $this->json(['errors' => 'wrong json format'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $loggedUser = $this->user->getUser();

        if (!$user) {
            throw $this->createNotFoundException();
        }

        if ($this->validator->validate($user, [UserDto::GROUP_UPDATE])) {
            return $this->json(['errors' => $this->validator->getErrors()]);
        }

        $user = $this->manager->update($user, $loggedUser);

        return $this->json(['user' => $user]);
    }

    /**
     * @Route("/avatar", name="avatar")
     */
    public function avatarAction(Request $request): JsonResponse
    {
        $loggedUser = $this->user->getUser();

        if (!$loggedUser) {
            throw $this->createNotFoundException();
        }

        $avatar = $request->files->get('file');

        $avatarPath = $this->manager->changeAvatar($avatar, $loggedUser);

        return $this->json(['avatar' => $avatarPath]);
    }
}
