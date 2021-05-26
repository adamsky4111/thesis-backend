<?php

namespace App\Tests\Service;


use App\Tests\AbstractTestCase as BaseTestCase;

abstract class AbstractServiceTest extends BaseTestCase
{
    protected array $services = [];
    protected array $servicesNames = [];

    protected abstract function setServices(): void;

    protected function setUp(): void
    {
        parent::setUp();
        $this->setServices();
        $this->loadServices();
    }

    protected function loadServices(): void
    {
        $container = self::$container;

        foreach ($this->servicesNames as $classService) {
            $service = $container->get($classService);
            $this->assertInstanceOf($classService, $service);
            $this->services[$classService] = $service;
        }
    }

    protected function getService(string $className): object
    {
        return $this->services[$className];
    }
}
