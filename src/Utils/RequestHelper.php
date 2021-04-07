<?php

namespace App\Utils;

use App\Serializer\Factory\SerializerFactory;
use Symfony\Component\HttpFoundation\Request;

class RequestHelper
{
    public static function denormalizeFromRequest(Request $request, string $className)
    {
        $requestData = json_decode($request->getContent(), true);
        $serializerFactory = SerializerFactory::getObjectNormalizer();

        return $serializerFactory->denormalize($requestData, $className);
    }
}
