<?php

namespace App\Service\Channel\Subscriber;

use App\Entity\Stream\Channel;
use App\Entity\User\AccountChannelSubscribe;
use App\Service\User\Context\AccountContextInterface;
use Doctrine\ORM\EntityManagerInterface;

final class DefaultChannelSubscriber implements ChannelSubscriberInterface
{
    public function __construct(
        private AccountContextInterface $context,
        private EntityManagerInterface $manager,
    ) {}

    /**
     * @throws \Exception
     */
    public function subscribe(Channel $channel): bool
    {
        $account = $this->context->getAccount();
        if (!$account) {
            throw new \Exception('Account not found');
        }
        if ($account->isChannelSubscribed($channel)) {
            throw new \Exception('Channel is already subscribed by account');
        }
        $sub = new AccountChannelSubscribe();
        $sub->setAccount($account);
        $sub->setChannel($channel);
        $sub->setCreatedAt(new \DateTime());
        $sub->setUpdatedAt(new \DateTime());
        $this->manager->persist($sub);

        $account->addSubscribe($sub);
        $this->manager->flush();

        return true;
    }

    public function unsubscribe(Channel $channel): bool
    {
        $account = $this->context->getAccount();
        if (!$account) {
            throw new \Exception('Account not found');
        }
        if (!$sub = $account->getSubscribeByChannel($channel)) {
            throw new \Exception('Channel is not subscribed by account');
        }
        $this->manager->remove($sub);
        $account->removeSubscribe($sub);
        $this->manager->flush();

        return true;
    }

    public function getSubscribed(): array
    {
        $account = $this->context->getAccount();
        if (!$account) {
            throw new \Exception('Account not found');
        }
        return $account->getSubscribes()->toArray();
    }
}
