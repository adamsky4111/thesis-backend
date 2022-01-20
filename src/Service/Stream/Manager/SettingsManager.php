<?php

namespace App\Service\Stream\Manager;

use App\Dto\SettingsDto;
use App\Entity\User\Account;
use App\Entity\User\Settings;
use App\Repository\User\SettingsRepositoryInterface;
use App\Service\Stream\Factory\SettingsFactoryInterface;
use App\Filter\SettingsFilter;
use App\Service\User\Context\AccountContextInterface;
use JetBrains\PhpStorm\ArrayShape;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class SettingsManager implements SettingsManagerInterface
{
    public function __construct(
        protected SettingsRepositoryInterface    $settings,
        protected SettingsFactoryInterface       $factory,
        protected AccountContextInterface        $account,
    ) {}

    #[ArrayShape([
        'items' => "array",
        'total' => "int",
        'pages' => "int"
    ])]
    public function getSettingsData(SettingsFilter $filter): iterable
    {
       return $this->settings->findByFilter($filter, $this->account->getAccount());
    }

    public function get(int $id): SettingsDto
    {
        return $this->settings->find($id);
    }

    public function getOr404(int $id): Settings
    {
        $settings = $this->settings->find($id);

        if (null === $settings) {
            throw new NotFoundHttpException();
        }

        return $settings;
    }

    public function create(SettingsDto $dto): SettingsDto
    {
        $account = $this->getAccountOr404();
        $settings = $this->factory->create($dto, $account);
        $this->settings->save($settings);

        return SettingsDto::createFromObject($settings);
    }

    public function update(SettingsDto $dto, Settings $settings): SettingsDto
    {
        $settings = $this->factory->update($dto, $settings);
        $this->settings->save($settings);

        return SettingsDto::createFromObject($settings);
    }

    protected function getAccountOr404(): Account
    {
        if (null === ($account = $this->account->getAccount())) {
            throw new NotFoundHttpException();
        }

        return $account;
    }

    public function delete(Settings $settings): SettingsDto
    {
        $removed = $this->settings->remove($settings);

        return SettingsDto::createFromObject($removed);
    }
}
