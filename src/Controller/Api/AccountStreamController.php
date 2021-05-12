<?php

namespace App\Controller\Api;

use App\Dto\ChannelDto;
use App\Dto\StreamDto;
use App\Serializer\StreamSerializer;
use App\Service\Stream\Manager\StreamManagerInterface;
use App\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/account/stream", name="api_account_stream_")
 */
class AccountStreamController extends AbstractController
{
    public function __construct(
        protected StreamSerializer $serializer,
        protected ValidatorInterface $validator,
        protected StreamManagerInterface $manager,
    ) {}


    /**
     * @Route("/", name="list", methods={"POST"})
     */
    public function listAction(Request $request): JsonResponse
    {

    }

    /**
     * @Route("/create", name="create", methods={"POST"})
     */
    public function createAction(Request $request): JsonResponse
    {
        try {
            /** @var StreamDto $stream */
            $stream = $this->serializer->denormalize($request->getContent());
        } catch (\Exception $exception) {
            return $this->json(['errors' => 'wrong json format', 'message' => $exception->getMessage()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if ($this->validator->validate($stream, [ChannelDto::GROUP_CREATE])) {
            return $this->json(['errors' => $this->validator->getErrors()]);
        }

        $stream = $this->manager->registerStream($stream);

        return $this->json(['stream' => $stream]);
    }

    /**
     * @Route("/edit/{id}", name="edit", methods={"PUT"})
     */
    public function editAction(Request $request, $id): JsonResponse
    {

    }

    /**
     * @Route("/show/{id}", name="show", methods={"GET"})
     */
    public function showAction(Request $request, $id): JsonResponse
    {

    }

    /**
     * @Route("/delete/{id}", name="delete", methods={"DELETE"})
     */
    public function deleteAction(Request $request, $id): JsonResponse
    {

    }
}
