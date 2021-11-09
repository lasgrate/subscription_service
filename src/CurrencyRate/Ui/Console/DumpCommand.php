<?php

declare(strict_types=1);

namespace KiloHealth\Subscription\Ui\Console;

use KiloHealth\Subscription\Application\Command\Dumper;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class DumpCommand extends Command
{
    protected static $defaultName = 'currency-rate:dump';

    public function __construct(
        private Dumper $dumper,
        private LoggerInterface $logger
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Dump actual currency rates for future')
            ->addOption(
                'rateDate', //name
                'd', //shortcut
                InputOption::VALUE_REQUIRED, //mode
            )->addOption(
                'dayCount', //name
                'dc', //shortcut
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
            $this->dumper->dump($rateDate, (int)$input->getOption('dayCount'));
        } catch (\Throwable $exception) {
            $this->logger->emergency('[DumpCommand] Cannot dump currency rates', [
                'exception' => $exception,
                'rateDate' => $rateDate,
            ]);
        }

        return Command::SUCCESS;
    }
}
