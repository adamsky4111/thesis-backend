<?php

namespace App\Tests\Service\Chat;

use App\DataFixtures\TestChannelFixtures;
use App\DataFixtures\TestStreamFixtures;
use App\DataFixtures\TestUserFixtures;
use App\DataFixtures\TestUserSettingFixtures;
use App\Dto\MessageDto;
use App\Entity\Stream\Chat;
use App\Entity\Stream\Stream;
use App\Entity\User\User;
use App\Service\Chat\Factory\DefaultMessageFactory;
use App\Tests\Service\AbstractServiceTest as BaseTestCase;
use Symfony\Component\Security\Core\Security;

class DefaultMessageFactoryTest extends BaseTestCase
{
    public function testCreate()
    {
        /** @var DefaultMessageFactory $service */
        $service = $this->getService(DefaultMessageFactory::class);

        /** @var User $user */
        $user = $this->getReferenceOfClass(TestUserFixtures::USER_REGULAR, User::class);

        /** @var Stream $stream */
        $stream = $this->getReferenceOfClass(TestStreamFixtures::USER_STREAM, Stream::class);

        $chat = $stream->getChat();

        $this->assertInstanceOf(Chat::class, $chat);

        $text = 'message';
        $dto = new MessageDto($text);

        $message = $service->create($dto, $chat, $user);

        $this->assertEquals($text, $message->getContent());
        $this->assertEquals($user, $message->getUser());
        $this->assertEquals($chat, $message->getChat());
    }


    public function setFixtures(): void
    {
        $this->fixtures = [
            TestUserFixtures::class,
            TestChannelFixtures::class,
            TestUserSettingFixtures::class,
            TestStreamFixtures::class,
        ];
    }

    protected function setServices(): void
    {
        $this->servicesNames = [
            DefaultMessageFactory::class,
            Security::class,
        ];
    }
}
