<?php

declare(strict_types=1);

namespace KiloHealth\Subscription\Application\Command\SubscriptionEventProcessor;

use KiloHealth\Subscription\Application\Dto\Callback\Product;
use KiloHealth\Subscription\Domain\Entity\Subscription;
use KiloHealth\Subscription\Domain\Entity\Transaction;
use KiloHealth\Subscription\Domain\Repository\SubscriptionRepositoryInterface;
use KiloHealth\Subscription\Domain\Repository\TransactionRepositoryInterface;
use KiloHealth\Subscription\Domain\ValueObject\Psp;
use KiloHealth\Subscription\Domain\ValueObject\Status;

class InitialPaymentProcessor implements SubscriptionEventProcessorInterface
{
    public function __construct(
        private SubscriptionRepositoryInterface $subscriptionRepository,
        private TransactionRepositoryInterface $transactionRepository
    ) {
    }

    public function process(Psp $psp, Product $product): void
    {
        $subscriptionId = $this->subscriptionRepository->generateSubscriptionId();
        $subscription = new Subscription(
            $subscriptionId,
            $product->getReference(),
            $product->getExpiredAt()
        );
        $this->subscriptionRepository->save($subscription);

        $transactionId = $this->transactionRepository->generateTransactionId();
        $transaction = new Transaction(
            $transactionId,
            $subscriptionId,
            Status::getObject(Status::STATUS_CHARGED),
            $psp
        );
        $this->transactionRepository->save($transaction);
    }
}
