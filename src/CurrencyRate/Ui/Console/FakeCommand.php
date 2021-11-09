<?php

declare(strict_types=1);

namespace KiloHealth\Subscription\Ui\Console;

use KiloHealth\Subscription\Application\Command\Faker;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class FakeCommand extends Command
{
    protected static $defaultName = 'currency-rate:fake';

    public function __construct(
        private Faker $faker,
        private LoggerInterface $logger
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Generate fake currency rates for present')
            ->addOption(
            'rateDate', //name
            'd', //shortcut
            InputOption::VALUE_REQUIRED, //mode
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $rateDate = $input->getOption('rateDate');

        if (!\is_null($rateDate)) {
            $rateDate = new \DateTimeImmutable($rateDate);
        }

        try {
            $this->faker->fake($rateDate);
        } catch (\Throwable $exception) {
            $this->logger->error('[FakeCommand] Cannot fake currency rates', [
                'exception' => $exception,
            ]);
        }

        return Command::SUCCESS;
    }
}
