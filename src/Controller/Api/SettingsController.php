<?php

namespace App\Controller\Api;

use App\Dto\SettingsDto;
use App\Serializer\SettingsSerializer;
use App\Service\Stream\Filter\SettingsFilter;
use App\Service\Stream\Manager\SettingsManagerInterface;
use App\Utils\RequestHelper;
use App\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/settings", name="api_security_")
 */
class SettingsController extends AbstractController
{
    public function __construct(
        private SettingsManagerInterface $manager,
        private SettingsSerializer $serializer,
        private ValidatorInterface $validator,
    ) {}

    /**
     * @Route("/", name="list", methods={"POST"})
     */
    public function listAction(Request $request): JsonResponse
    {
        /** @var SettingsFilter $filter */
        $filter = RequestHelper::denormalizeFromRequest($request, SettingsFilter::class);
        $result = $this->manager->getSettingsData($filter);

        return $this->json(
            $result
        );
    }

    /**
     * @Route("/get/{id}", name="get", methods={"GET"})
     */
    public function getAction($id): JsonResponse
    {
        $settings = $this->manager->getOr404($id);

        return $this->json(['settings' => $settings]);
    }

    /**
     * @Route("/edit/{id}", name="edit", methods={"PUT"})
     */
    public function editAction(Request $request, $id): JsonResponse
    {
        $settings = $this->manager->getOr404($id);
        try {
            /** @var SettingsDto $dto */
            $dto = $this->serializer->denormalize($request->getContent());
        } catch (\Exception) {
            return $this->json(['errors' => 'wrong json format'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if ($this->validator->validate($dto, [SettingsDto::GROUP_UPDATE])) {
            return $this->json(['errors' => $this->validator->getErrors()]);
        }

        $settings = $this->manager->update($dto, $settings);

        return $this->json(['settings' => $settings]);
    }

    /**
     * @Route("/create", name="create", methods={"POST"})
     */
    public function createAction(Request $request): JsonResponse
    {
        try {
            /** @var SettingsDto $dto */
            $dto = $this->serializer->denormalize($request->getContent());
        } catch (\Exception) {
            return $this->json(['errors' => 'wrong json format'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if ($this->validator->validate($dto, [SettingsDto::GROUP_CREATE])) {
            return $this->json(['errors' => $this->validator->getErrors()]);
        }

        $settings = $this->manager->create($dto);

        return $this->json(['settings' => $settings]);
    }

    /**
     * @Route("/delete/{id}", name="delete", methods={"DELETE"})
     */
    public function deleteAction($id): JsonResponse
    {
        $settings = $this->manager->getOr404($id);

        $this->manager->delete($settings);

        return $this->json(['settings' => $settings]);
    }
}
