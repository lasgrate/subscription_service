<?php

declare(strict_types=1);

namespace KiloHealth\Subscription\Application\Command\SubscriptionEventProcessor;

use KiloHealth\Subscription\Application\Dto\Callback\Product;
use KiloHealth\Subscription\Domain\Entity\Transaction;
use KiloHealth\Subscription\Domain\Repository\SubscriptionRepositoryInterface;
use KiloHealth\Subscription\Domain\Repository\TransactionRepositoryInterface;
use KiloHealth\Subscription\Domain\ValueObject\Psp;
use KiloHealth\Subscription\Domain\ValueObject\Status;

class FailedRenewSubscriptionProcessor implements SubscriptionEventProcessorInterface
{
    public function __construct(
        private SubscriptionRepositoryInterface $subscriptionRepository,
        private TransactionRepositoryInterface $transactionRepository
    ) {
    }

    public function process(Psp $psp, Product $product): void
    {
        $subscription = $this->subscriptionRepository->findByReference($product->getReference());

        if (\is_null($subscription)) {
            throw new \UnexpectedValueException('Subscription not found');
        }

        $transactionId = $this->transactionRepository->generateTransactionId();
        $transaction = new Transaction(
            $transactionId,
            $subscription->getSubscriptionId(),
            Status::getObject(Status::STATUS_DECLINED),
            $psp
        );
        $this->transactionRepository->save($transaction);
    }
}
