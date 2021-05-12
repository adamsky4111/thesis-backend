<?php

namespace App\Controller\Api\Public;

use App\Dto\ChannelDto;
use App\Dto\StreamDto;
use App\Filter\SearchFilter;
use App\Serializer\StreamSerializer;
use App\Service\Stream\Manager\StreamManagerInterface;
use App\Utils\RequestHelper;
use App\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/stream", name="api_stream_")
 */
class StreamController extends AbstractController
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
        /** @var SearchFilter $filter */
        $filter = RequestHelper::denormalizeFromRequest($request, SearchFilter::class);
        $result = $this->manager->searchByFilter($filter);

        return $this->json($result);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     */
    public function showAction(Request $request, $id): JsonResponse
    {
        $stream = $this->manager->getOr404($id);

        $serialized = $this->serializer->normalize($stream, null, ['groups' => StreamDto::GROUP_SHOW]);

        return $this->json(['stream' => $serialized]);
    }
}
