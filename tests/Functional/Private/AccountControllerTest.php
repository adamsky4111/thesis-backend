<?php

namespace App\Tests\Functional\Private;

use App\DataFixtures\TestUserFixtures;
use App\Tests\Functional\AbstractFunctionalTest as BaseTestCase;
use Symfony\Component\HttpFoundation\Request;

class AccountControllerTest extends BaseTestCase
{
    public function testEditProfileApi()
    {
        $this->login();

        $sendData = [
            'email' => 'change_email@gtest.com',
            'username' => 'change_username',
            'plainPassword' => 'sdfsfsdf',
            'firstName' => 'change_first',
            'lastName' => 'change_last',
            'nick' => 'change_nick',
            'country' => 'PL',
            'about' => 'change_about',
        ];

        $this->client->request(
            method: Request::METHOD_GET,
            uri: $this->generateUrl('api_account_edit'),
            server: ['HTTP_ACCEPT' => 'application/json'],
            content: json_encode($sendData)
        );

        $respData = $this->getResponseContent();
        $this->assertTrue(is_array($respData));
        $this->assertTrue(isset($respData['user']));
        $this->assertEquals(
            $respData['user']['email'],
            $this->loggedUserData['email']
        );
        $this->assertNotEquals(
            $respData['user']['email'],
            $sendData['email']
        );
        $this->assertEquals(
            $respData['user']['username'],
            $this->loggedUserData['username']
        );
        $this->assertNotEquals(
            $respData['user']['username'],
            $sendData['username']
        );
        $this->assertEquals(
            $respData['user']['firstName'],
            $sendData['firstName']
        );
        $this->assertEquals(
            $respData['user']['lastName'],
            $sendData['lastName']
        );
        $this->assertEquals(
            $respData['user']['nick'],
            $sendData['nick']
        );
        $this->assertEquals(
            $respData['user']['country'],
            $sendData['country']
        );
        $this->assertEquals(
            $respData['user']['about'],
            $sendData['about']
        );
    }

    function setFixtures(): void
    {
        $this->fixtures = [
            TestUserFixtures::class,
        ];
    }
}
