<?php

namespace App\Service\Stream\Factory;

use App\Dto\SettingsDto;
use App\Entity\User\Account;
use App\Entity\User\Settings;
use Doctrine\ORM\EntityManagerInterface;

final class DefaultSettingsFactory implements SettingsFactoryInterface
{
    public function __construct(
        protected EntityManagerInterface $em,
    ) {}


    public function create(SettingsDto $dto, Account $account): Settings
    {
        $settings = new Settings();
        $settings->setName($dto->getName());
        $settings->setAgeAllowed($dto->getAgeAllowed());
        $settings->setIsDefault($dto->isDefault());
        if ($dto->isDefault()) {
            /** @var Settings $setting */
            foreach ($account->getSettings() as $setting) {
                $setting->setIsDefault(false);
            }
        }
        $account->addSettings($settings);

        return $settings;
    }

    public function update(SettingsDto $dto, Settings $settings): Settings
    {
        $account = $settings->getAccount();
        if ($dto->isDefault()) {
            /** @var Settings $setting */
            foreach ($account->getSettings() as $setting) {
                $setting->setIsDefault(false);
            }
        }
        $settings->setName($dto->getName());
        $settings->setAgeAllowed($dto->getAgeAllowed());
        $settings->setIsDefault($dto->isDefault());

        return $settings;
    }
}
