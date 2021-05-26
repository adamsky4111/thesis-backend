<?php

namespace App\Tests\Service\User;

use App\Utils\Test\UserTestHelper;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserDtoTest extends KernelTestCase
{
    public function testDtoCreate()
    {
        $data = UserTestHelper::createValidUserDto();
        [$dto, [$username, $email, $password, $firstName, $lastName, $nick, $country, $about]] = $data;
        $this->assertEquals($username, $dto->getUsername());
        $this->assertEquals($email, $dto->getEmail());
        $this->assertEquals($password, $dto->getPlainPassword());
        $this->assertEquals($firstName, $dto->getFirstName());
        $this->assertEquals($lastName, $dto->getLastName());
        $this->assertEquals($nick, $dto->getNick());
        $this->assertEquals($country, $dto->getCountry());
        $this->assertEquals($about, $dto->getAbout());
    }
}