<?php

namespace App\Serializer\Factory;

use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;

class SerializerFactory
{
    /**
     * Creates basic entity/object normalizer instance
     *
     * @param array $defaultContext = [];
     * @return Serializer
     */
    static function getObjectNormalizer(array $defaultContext = []): Serializer
    {
        $classMetadataFactory = new ClassMetadataFactory(
            new AnnotationLoader(
                new AnnotationReader()
            )
        );

        $normalizers = [
            new DateTimeNormalizer(),
            new AnnotationReader(),
            new ObjectNormalizer(
                $classMetadataFactory,
                null,
                null,
                new ReflectionExtractor(),
                null,
                null,
                $defaultContext
            )
        ];
        $encoders = [
            new JsonEncoder()
        ];

        return new Serializer($normalizers, $encoders);
    }
}
