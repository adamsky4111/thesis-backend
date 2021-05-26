<?php

namespace App\Tests\Service\User;

use App\DataFixtures\TestUserFixtures;
use App\Entity\User\Account;
use App\Entity\User\AccountInformation;
use App\Entity\User\User;
use App\Enum\AccountRoleEnum;
use App\Enum\UserRoleEnum;
use App\Service\User\Dto\UserDto;
use App\Service\User\Factory\DefaultUserFactory;
use App\Service\User\Factory\UserFactoryInterface;
use App\Tests\Service\AbstractServiceTest as BaseTestCase;
use App\Utils\Test\UserTestHelper;

class UserFactoryTest extends BaseTestCase
{
    public function testUserCreate()
    {
        $container = self::$container;
        /** @var UserFactoryInterface $factory */
        $factory = $container->get(UserFactoryInterface::class);

        $data = UserTestHelper::createValidUserDto();
        /** @var UserDto $dto */
        [$dto, ] = $data;

        // podstawowa konfiguracja dependency injection powinna wskazywać na podstawową fabrykę
        $this->assertInstanceOf(DefaultUserFactory::class, $factory);

        $user = $factory->create($dto);

        $this->assertInstanceOf(User::class, $user);
        $this->assertInstanceOf(Account::class, $account = $user->getAccount());
        $this->assertInstanceOf(AccountInformation::class, $info = $account->getAccountInformation());
        $this->assertEquals($dto->getUsername(), $user->getUsernameCanonical());
        $this->assertEquals($dto->getEmail(), $user->getEmailCanonical());
        $this->assertEquals(null, $user->getPlainPassword());
        $this->assertEquals($dto->getFirstName(), $info->getFirstName());
        $this->assertEquals($dto->getLastName(), $info->getLastName());
        $this->assertEquals($dto->getNick(), $info->getNick());
        $this->assertEquals($dto->getCountry(), $info->getCountry());
        $this->assertEquals($dto->getAbout(), $info->getAbout());
        $this->assertEquals(false, $user->getIsActive());
        $this->assertEquals(false, $user->getIsDeleted());
        $this->assertEquals([UserRoleEnum::ROLE_USER], $user->getRoles());
        $this->assertEquals([AccountRoleEnum::REGULAR_ACCOUNT], $account->getRoles());
    }

    public function testUserUpdate()
    {
        $container = self::$container;
        $fixture = $container->get(TestUserFixtures::class);
        /** @var User $regular */
        $regular = $fixture->getReference(TestUserFixtures::USER_REGULAR);
        $account = $regular->getAccount();
        $accountInfo = $account->getAccountInformation();

        $data = [
            $regular->getUsernameCanonical(),
            $regular->getEmailCanonical(),
            $regular->getPlainPassword(),
            $accountInfo->getFirstName(),
            $accountInfo->getLastName(),
            $accountInfo->getNick(),
            $accountInfo->getCountry(),
            $accountInfo->getAbout(),
        ];
        $data2 = array_map(fn ($item) => 'modify'.$item, $data);

        /** @var UserFactoryInterface $factory */
        $factory = $container->get(UserFactoryInterface::class);
        /** @var UserDto $dto */
        [$dto, ] = UserTestHelper::createFromArray($data2);

        $user = $factory->update($dto, $regular);
        $account = $user->getAccount();
        $accountInfo = $account->getAccountInformation();

        $this->assertNotEquals($dto->getUsername(), $user->getUsernameCanonical());
        $this->assertNotEquals($dto->getEmail(), $user->getEmailCanonical());
        $this->assertEquals($dto->getFirstName(), $accountInfo->getFirstName());
        $this->assertEquals($dto->getLastName(), $accountInfo->getLastName());
        $this->assertEquals($dto->getNick(), $accountInfo->getNick());
        $this->assertEquals($dto->getCountry(), $accountInfo->getCountry());
        $this->assertEquals($dto->getAbout(), $accountInfo->getAbout());
        $this->assertEquals(false, $user->getIsActive());
        $this->assertEquals(false, $user->getIsDeleted());
        $this->assertEquals([UserRoleEnum::ROLE_USER], $user->getRoles());
        $this->assertEquals([AccountRoleEnum::REGULAR_ACCOUNT], $account->getRoles());
    }

    public function setFixtures(): void
    {
        $this->fixtures = [
            TestUserFixtures::class
        ];
    }

    protected function setServices(): void
    {
        // TODO: Implement setServices() method.
    }
}
