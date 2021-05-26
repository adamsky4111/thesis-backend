<?php

namespace App\Tests\Functional;


use App\Entity\User\User;
use App\Enum\AccountRoleEnum;
use App\Enum\UserRoleEnum;
use App\Repository\User\UserRepositoryInterface;
use App\Tests\AbstractTestCase as BaseTestCase;
use App\Utils\Test\UserTestHelper;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

abstract class AbstractFunctionalTest extends BaseTestCase
{
    protected ?KernelBrowser $client = null;
    protected ?string $firewallName = null;
    protected ?string $firewalContext = null;
    protected array $loggedUserData = [];
    protected array $loggedUserRoles = [];

    protected function setUp(): void
    {
        $this->client = self::createClient();
        parent::setUp();
    }

    protected function login(string $userType = UserRoleEnum::ROLE_USER, $accountType = AccountRoleEnum::REGULAR_ACCOUNT)
    {
        if ($userType === UserRoleEnum::ROLE_USER) {
            $userData = UserTestHelper::$credentials[$userType][$accountType];
        } else {
            $userData = UserTestHelper::$credentials[$userType];
        }

        $username = $userData['username'];
        $password = $userData['password'];

        $this->client->request(
            method: Request::METHOD_POST,
            uri: '/api/login_check',
            server: ['CONTENT_TYPE' => 'application/json'],
            content: json_encode([
                'username' => $username,
                'password' => $password,
            ])
        );

        $data = json_decode($this->client->getResponse()->getContent(), true);

        $this->loggedUserData = $data['user'];
        $this->loggedUserRoles = $data['roles'];

        $this->client->setServerParameter('HTTP_Authorization', sprintf('Bearer %s', $data['token']));
    }

    protected function generateUrl(string $routeName, array $params = []): string
    {
        /** @var UrlGeneratorInterface $urlGenerator */
        $urlGenerator = self::$container->get(UrlGeneratorInterface::class);

        return $urlGenerator->generate($routeName, $params);
    }

    protected function getResponseContent(): array
    {
        return json_decode($this->client->getResponse()->getContent(), true);
    }

    protected function logout(): void
    {
        $this->client->setServerParameter('HTTP_Authorization', null);
        $this->loggedUserData = [];
        $this->loggedUserRoles = [];
    }

    protected function loadUser(string $email): ?User
    {
        return self::$container->get(UserRepositoryInterface::class)->findByEmailOrUsername($email);
    }
}
