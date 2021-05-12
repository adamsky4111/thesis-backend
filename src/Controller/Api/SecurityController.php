<?php

namespace App\Controller\Api;

use App\Repository\User\UserRepositoryInterface;
use App\Serializer\UserSerializer;
use App\Service\User\Dto\UserDto;
use App\Service\User\Manager\RestorePasswordInterface;
use App\Service\User\Manager\UserManagerInterface;
use App\Service\User\Manager\UserVerifierInterface;
use App\Service\User\Model\ConfirmationAccountModel;
use App\Service\User\Model\RestorePasswordModel;
use App\Utils\RequestHelper;
use App\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

/**
 * @Route("/api/security", name="api_security_")
 */
class SecurityController extends AbstractController
{
    public function __construct(
        private UserSerializer $serializer,
        private UserManagerInterface $manager,
        private ValidatorInterface $validator,
        private UserVerifierInterface $verifier,
        private RestorePasswordInterface $restore,
        private UserRepositoryInterface $users,
    ) {}

    /**
     * @Route("/register", name="register", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     * @throws ExceptionInterface
     */
    public function registerAction(Request $request): JsonResponse
    {
        try {
            /** @var UserDto $user */
            $user = $this->serializer->denormalize($request->getContent());
        } catch (\Exception) {
            return $this->json(['errors' => 'wrong json format'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if ($this->validator->validate($user, [UserDto::GROUP_CREATE])) {
            return $this->json(['errors' => $this->validator->getErrors()]);
        }

        $user = $this->manager->register($user);

        return $this->json(['data' => $user]);
    }

    /**
     * @Route("/verify", name="verify")
     * @param Request $request
     * @return JsonResponse
     */
    public function verifyAction(Request $request): JsonResponse
    {
        /** @var ConfirmationAccountModel $model */
        $model = RequestHelper::denormalizeFromRequest($request, ConfirmationAccountModel::class);

        if (!$user = $this->users->findOneByEmail($model->getEmail())) {
            $this->createNotFoundException();
        }

        $verified = $this->verifier->verify($user, $model->getToken());

        return $this->json([], $verified ? 200 : 400);
    }

    /**
     * @Route("/restore-password/{token}", name="restore_password_token")
     * @param Request $request
     * @param $token
     * @return JsonResponse
     */
    public function restorePasswordTokenAction(Request $request, $token): JsonResponse
    {
        /** @var RestorePasswordModel $model */
        $model = RequestHelper::denormalizeFromRequest($request, RestorePasswordModel::class);

        if (!$user = $this->users->findOneByEmail($model->getEmail())) {
            $this->createNotFoundException();
        }

        $restored = $this->restore->restorePassword($user, $model->getPassword(), $token);

        return $this->json([], $restored ? 200 : 400);
    }

    /**
     * @Route("/restore-password", name="restore_password")
     * @param Request $request
     * @return JsonResponse
     */
    public function restorePasswordAction(Request $request): JsonResponse
    {
        /** @var RestorePasswordModel $model */
        $model = RequestHelper::denormalizeFromRequest($request, RestorePasswordModel::class);

        if (!$user = $this->users->findOneByEmail($model->getEmail())) {
            $this->createNotFoundException();
        }

        $generated = $this->restore->generateToken($user);

        return $this->json([], $generated ? 200 : 400);
    }
}
