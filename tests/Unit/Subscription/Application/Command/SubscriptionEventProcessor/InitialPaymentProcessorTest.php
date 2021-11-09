<?php

declare(strict_types=1);

namespace KiloHealth\Subscription\Tests\Unit\Subscription\Application\Command\SubscriptionEventProcessor;

use KiloHealth\Lib\AbstractUuid;
use KiloHealth\Subscription\Application\Command\SubscriptionEventProcessor\InitialPaymentProcessor;
use KiloHealth\Subscription\Application\Dto\Callback\Product;
use KiloHealth\Subscription\Domain\Entity\Subscription;
use KiloHealth\Subscription\Domain\Entity\Transaction;
use KiloHealth\Subscription\Domain\Repository\SubscriptionRepositoryInterface;
use KiloHealth\Subscription\Domain\Repository\TransactionRepositoryInterface;
use KiloHealth\Subscription\Domain\ValueObject\PaymentGateway;
use KiloHealth\Subscription\Domain\ValueObject\Status;
use KiloHealth\Subscription\Domain\ValueObject\SubscriptionId;
use KiloHealth\Subscription\Domain\ValueObject\TransactionId;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class InitialPaymentProcessorTest extends TestCase
{
    /**
     * @var SubscriptionRepositoryInterface|MockObject
     */
    private SubscriptionRepositoryInterface $subscriptionRepositoryMock;

    /**
     * @var TransactionRepositoryInterface|MockObject
     */
    private TransactionRepositoryInterface $transactionRepositoryMock;

    private InitialPaymentProcessor $initialPaymentProcessor;

    protected function setUp(): void
    {
        $this->subscriptionRepositoryMock = $this->createMock(SubscriptionRepositoryInterface::class);
        $this->transactionRepositoryMock = $this->createMock(TransactionRepositoryInterface::class);
        $this->initialPaymentProcessor = new InitialPaymentProcessor(
            $this->subscriptionRepositoryMock,
            $this->transactionRepositoryMock
        );
    }

    protected function tearDown(): void
    {
        unset(
            $this->subscriptionRepositoryMock,
            $this->transactionRepositoryMock,
            $this->initialPaymentProcessor,
        );
    }

    public function processDataProvider(): \Traversable
    {
        $default = [
            'paymentGateway' => PaymentGateway::getObject(PaymentGateway::PSP_APPLE_PAY),
            'product' => new Product(
                'testReference',
                'testProductId',
                new \DateTimeImmutable('2021-01-01')
            ),
            'subscriptionId' => new SubscriptionId(\md5('subscriptionId')),
            'subscription' => new Subscription(
                new SubscriptionId(\md5('subscriptionId')),
                'testReference',
                new \DateTimeImmutable('2021-01-01'),
            ),
            'transactionId' => new TransactionId(\md5('transactionId')),
            'transaction' => new Transaction(
                new TransactionId(\md5('transactionId')),
                new SubscriptionId(\md5('subscriptionId')),
                Status::getObject(Status::STATUS_DECLINED),
                PaymentGateway::getObject(PaymentGateway::PSP_APPLE_PAY)
            ),
        ];

        yield 'default' => $default;
    }

    /**
     * @dataProvider processDataProvider
     */
    public function testProcess(
        PaymentGateway $paymentGateway,
        Product $product,
        SubscriptionId $subscriptionId,
        Subscription $subscription,
        TransactionId $transactionId,
        Transaction $transaction
    ): void {
        $this->subscriptionRepositoryMock
            ->expects($this->once())
            ->method('generateSubscriptionId')
            ->willReturn($subscriptionId);

        $this->subscriptionRepositoryMock
            ->expects($this->once())
            ->method('save')
            ->with($subscription);

        $this->transactionRepositoryMock
            ->expects($this->once())
            ->method('generateTransactionId')
            ->willReturn($transactionId);

        $this->transactionRepositoryMock
            ->expects($this->once())
            ->method('save')
            ->with($transaction);

        $this->initialPaymentProcessor->process($paymentGateway, $product);
    }
}
